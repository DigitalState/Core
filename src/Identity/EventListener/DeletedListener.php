<?php

namespace Ds\Component\Identity\EventListener;

use ApiPlatform\Core\DataProvider\PaginatorInterface as Paginator;
use Ds\Component\Model\Type\Deletable;
use LogicException;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Class DeletedListener
 *
 * @package Ds\Component\Identity
 */
final class DeletedListener
{
    /**
     * @var \Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface
     */
    private $tokenStorage;

    /**
     * @var \Symfony\Component\Security\Core\Authorization\Voter\VoterInterface
     */
    private $deletedVoter;

    /**
     * Constructor
     *
     * @param \Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface $tokenStorage
     * @param \Symfony\Component\Security\Core\Authorization\Voter\VoterInterface $deletedVoter
     */
    public function __construct(TokenStorageInterface $tokenStorage, VoterInterface $deletedVoter)
    {
        $this->tokenStorage = $tokenStorage;
        $this->deletedVoter = $deletedVoter;
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

        if (!in_array(Deletable::class, class_implements($entity), true)) {
            return;
        }

        $token = $this->tokenStorage->getToken();

        if (!$token) {
            return;
        }

        $data = $request->attributes->get('data');

        if ($data instanceof Paginator || is_array($data)) {
            foreach ($data as $item) {
                $vote = $this->deletedVoter->vote($token, $item, ['*']);

                if (VoterInterface::ACCESS_ABSTAIN === $vote) {
                    throw new LogicException('Voter cannot abstain from voting.');
                }

                if (VoterInterface::ACCESS_GRANTED !== $vote) {
                    throw new AccessDeniedException('Access denied.');
                }
            }
        } else {
            $vote = $this->deletedVoter->vote($token, $data, ['*']);

            if (VoterInterface::ACCESS_ABSTAIN === $vote) {
                throw new LogicException('Voter cannot abstain from voting.');
            }

            if (VoterInterface::ACCESS_GRANTED !== $vote) {
                throw new AccessDeniedException('Access denied.');
            }
        }
    }
}
