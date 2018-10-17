<?php

namespace Ds\Component\Security\EventListener\Acl\Permission;

use ApiPlatform\Core\DataProvider\PaginatorInterface as Paginator;
use Ds\Component\Security\Model\Permission;
use Ds\Component\Security\Model\Type\Secured;
use Ds\Component\Security\Voter\Permission\EntityVoter;
use LogicException;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Class EntityListener
 *
 * @package Ds\Component\Security
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
        $request = $event->getRequest();
        $entity = $request->attributes->get('_api_resource_class');

        if (null === $entity) {
            return;
        }

        if (!in_array(Secured::class, class_implements($entity), true)) {
            return;
        }

        $token = $this->tokenStorage->getToken();

        if (!$token) {
            return;
        }

        switch (true) {
            case 'get' === $request->attributes->get('_api_collection_operation_name'):
                $attribute = Permission::BROWSE;
                break;

            case 'get' === $request->attributes->get('_api_item_operation_name'):
                $attribute = Permission::READ;
                break;

            case 'put' === $request->attributes->get('_api_item_operation_name'):
                $attribute = Permission::EDIT;
                break;

            case 'post' === $request->attributes->get('_api_collection_operation_name'):
                $attribute = Permission::ADD;
                break;

            case 'delete' === $request->attributes->get('_api_item_operation_name'):
                $attribute = Permission::DELETE;
                break;

            default:
                return;
        }

        $data = $request->attributes->get('data');

        if ($data instanceof Paginator || is_array($data)) {
            foreach ($data as $item) {
                $vote = $this->entityVoter->vote($token, $item, [$attribute]);

                if (EntityVoter::ACCESS_ABSTAIN === $vote) {
                    throw new LogicException('Voter cannot abstain from voting.');
                }

                if (EntityVoter::ACCESS_GRANTED !== $vote) {
                    throw new AccessDeniedException('Access denied.');
                }
            }
        } else {
            $vote = $this->entityVoter->vote($token, $data, [$attribute]);

            if (EntityVoter::ACCESS_ABSTAIN === $vote) {
                throw new LogicException('Voter cannot abstain from voting.');
            }

            if (EntityVoter::ACCESS_GRANTED !== $vote) {
                throw new AccessDeniedException('Access denied.');
            }
        }
    }
}
