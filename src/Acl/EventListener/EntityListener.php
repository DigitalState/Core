<?php

namespace Ds\Component\Acl\EventListener;

use ApiPlatform\Core\DataProvider\PaginatorInterface as Paginator;
use Ds\Component\Acl\Collection\EntityCollection;
use Ds\Component\Acl\Model\Permission;
use LogicException;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Class EntityListener
 *
 * @package Ds\Component\Acl
 */
final class EntityListener
{
    /**
     * @var \Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface
     */
    private $tokenStorage;

    /**
     * @var \Symfony\Component\Security\Core\Authorization\Voter\VoterInterface
     */
    private $voter;

    /**
     * @var \Ds\Component\Acl\Collection\EntityCollection
     */
    private $entityCollection;

    /**
     * Constructor
     *
     * @param \Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface $tokenStorage
     * @param \Symfony\Component\Security\Core\Authorization\Voter\VoterInterface $voter
     * @param \Ds\Component\Acl\Collection\EntityCollection $entityCollection
     */
    public function __construct(TokenStorageInterface $tokenStorage, VoterInterface $voter, EntityCollection $entityCollection)
    {
        $this->tokenStorage = $tokenStorage;
        $this->voter = $voter;
        $this->entityCollection = $entityCollection;
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

        if (!$this->entityCollection->contains($entity)) {
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
                $vote = $this->voter->vote($token, $item, [$attribute]);

                if (VoterInterface::ACCESS_ABSTAIN === $vote) {
                    throw new LogicException('Voter cannot abstain from voting.');
                }

                if (VoterInterface::ACCESS_GRANTED !== $vote) {
                    throw new AccessDeniedException('Access denied.');
                }
            }
        } else {
            $vote = $this->voter->vote($token, $data, [$attribute]);

            if (VoterInterface::ACCESS_ABSTAIN === $vote) {
                throw new LogicException('Voter cannot abstain from voting.');
            }

            if (VoterInterface::ACCESS_GRANTED !== $vote) {
                throw new AccessDeniedException('Access denied.');
            }
        }
    }
}
