<?php

namespace Ds\Component\Security\EventListener\Acl;

use ApiPlatform\Core\DataProvider\PaginatorInterface as Paginator;
use Ds\Component\Model\Type\Identitiable;
use Ds\Component\Security\Voter\IdentityVoter;
use LogicException;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Class IdentityListener
 *
 * @package Ds\Component\Security
 */
class IdentityListener
{
    /**
     * @var \Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface
     */
    protected $tokenStorage;

    /**
     * @var \Ds\Component\Security\Voter\IdentityVoter
     */
    protected $identityVoter;

    /**
     * Constructor
     *
     * @param \Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface $tokenStorage
     * @param \Ds\Component\Security\Voter\IdentityVoter $identityVoter
     */
    public function __construct(TokenStorageInterface $tokenStorage, IdentityVoter $identityVoter)
    {
        $this->tokenStorage = $tokenStorage;
        $this->identityVoter = $identityVoter;
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

        if (!in_array(Identitiable::class, class_implements($entity), true)) {
            return;
        }

        $data = $request->attributes->get('data');

        if ($data instanceof Paginator || is_array($data)) {
            foreach ($data as $item) {
                $vote = $this->identityVoter->vote($token, $item, ['*']);

                if (IdentityVoter::ACCESS_ABSTAIN === $vote) {
                    throw new LogicException('Voter cannot abstain from voting.');
                }

                if (IdentityVoter::ACCESS_GRANTED !== $vote) {
                    throw new AccessDeniedException('Access denied.');
                }
            }
        } else {
            $vote = $this->identityVoter->vote($token, $data, ['*']);

            if (IdentityVoter::ACCESS_ABSTAIN === $vote) {
                throw new LogicException('Voter cannot abstain from voting.');
            }

            if (IdentityVoter::ACCESS_GRANTED !== $vote) {
                throw new AccessDeniedException('Access denied.');
            }
        }
    }
}
