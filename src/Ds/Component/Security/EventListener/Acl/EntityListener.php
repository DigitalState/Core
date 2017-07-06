<?php

namespace Ds\Component\Security\EventListener\Acl;

use ApiPlatform\Core\Bridge\Doctrine\Orm\Paginator;
use Ds\Component\Model\Type\Ownable;
use Ds\Component\Security\Model\Permission;
use Ds\Component\Security\Voter\Permission\EntityVoter;
use LogicException;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Class EntityListener
 */
class EntityListener
{
    /**
     * @var \Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface
     */
    protected $tokenStorage;

    /**
     * @var \Ds\Component\Security\Voter\Permission\EntityVoter
     */
    protected $entityVoter;

    /**
     * Constructor
     *
     * @param \Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface $tokenStorage
     * @param \Ds\Component\Security\Voter\Permission\EntityVoter $entityVoter
     */
    public function __construct(TokenStorageInterface $tokenStorage, EntityVoter $entityVoter)
    {
        $this->tokenStorage = $tokenStorage;
        $this->entityVoter = $entityVoter;
    }

    /**
     * Deny access if the user does not have proper permissions
     *
     * @param \Symfony\Component\HttpKernel\Event\GetResponseEvent $event
     */
    public function kernelRequest(GetResponseEvent $event)
    {
        $token = $this->tokenStorage->getToken();

        if (!$token) {
            return;
        }

        $request = $event->getRequest();
        $entity = $request->attributes->get('_api_resource_class');

        if (null === $entity) {
            return;
        }

        if (!in_array(Ownable::class, class_implements($entity), true)) {
            return;
        }

        $permission = null;

        if ('get' === $request->attributes->get('_api_collection_operation_name')) {
            $permission = Permission::BROWSE;
        } elseif ('get' === $request->attributes->get('_api_item_operation_name')) {
            $permission = Permission::READ;
        } elseif ('post' === $request->attributes->get('_api_collection_operation_name')) {
            $permission = Permission::ADD;
        } elseif ('put' === $request->attributes->get('_api_item_operation_name')) {
            $permission = Permission::EDIT;
        } elseif ('delete' === $request->attributes->get('_api_item_operation_name')) {
            $permission = Permission::DELETE;
        }

        if (null === $permission) {
            return;
        }

        $data = $request->attributes->get('data');
        $subject = [
            'type' => Permission::ENTITY,
            'subject' => $entity
        ];

        if ($data instanceof Paginator) {
            foreach ($data as $item) {
                $subject['entity'] = $item->getOwner();
                $subject['entity_uuid'] = $item->getOwnerUuid();
                $vote = $this->entityVoter->vote($token, $subject, [$permission]);

                if (EntityVoter::ACCESS_ABSTAIN === $vote) {
                    throw new LogicException('Voter cannot abstain from voting.');
                }

                if (EntityVoter::ACCESS_GRANTED !== $vote) {
                    throw new AccessDeniedException('Access denied.');
                }
            }
        } else {
            $subject['entity'] = $data->getOwner();
            $subject['entity_uuid'] = $data->getOwnerUuid();
            $vote = $this->entityVoter->vote($token, $subject, [$permission]);

            if (EntityVoter::ACCESS_ABSTAIN === $vote) {
                throw new LogicException('Voter cannot abstain from voting.');
            }

            if (EntityVoter::ACCESS_GRANTED !== $vote) {
                throw new AccessDeniedException('Access denied.');
            }
        }
    }
}
