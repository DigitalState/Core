<?php

namespace Ds\Component\Identity\EventListener;

use ApiPlatform\Core\DataProvider\PaginatorInterface as Paginator;
use Ds\Component\Model\Type\Enableable;
use LogicException;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Class EnabledListener
 *
 * @package Ds\Component\Identity
 */
final class EnabledListener
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
     * Constructor
     *
     * @param \Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface $tokenStorage
     * @param \Symfony\Component\Security\Core\Authorization\Voter\VoterInterface $voter
     */
    public function __construct(TokenStorageInterface $tokenStorage, VoterInterface $voter)
    {
        $this->tokenStorage = $tokenStorage;
        $this->voter = $voter;
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

        if (!in_array(Enableable::class, class_implements($entity), true)) {
            return;
        }

        $token = $this->tokenStorage->getToken();
        $data = $request->attributes->get('data');

        if ($data instanceof Paginator || is_array($data)) {
            foreach ($data as $item) {
                $vote = $this->voter->vote($token, $item, ['*']);

                if (VoterInterface::ACCESS_ABSTAIN === $vote) {
                    throw new LogicException('Voter cannot abstain from voting.');
                }

                if (VoterInterface::ACCESS_GRANTED !== $vote) {
                    throw new AccessDeniedException('Access denied.');
                }
            }
        } else {
            $vote = $this->voter->vote($token, $data, ['*']);

            if (VoterInterface::ACCESS_ABSTAIN === $vote) {
                throw new LogicException('Voter cannot abstain from voting.');
            }

            if (VoterInterface::ACCESS_GRANTED !== $vote) {
                throw new AccessDeniedException('Access denied.');
            }
        }
    }
}
