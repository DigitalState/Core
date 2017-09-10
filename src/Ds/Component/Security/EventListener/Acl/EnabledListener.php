<?php

namespace Ds\Component\Security\EventListener\Acl;

use ApiPlatform\Core\DataProvider\PaginatorInterface as Paginator;
use Ds\Component\Model\Type\Enableable;
use Ds\Component\Model\Type\Identitiable;
use Ds\Component\Security\Voter\EnabledVoter;
use LogicException;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Class EnabledListener
 *
 * @package Ds\Component\Security
 */
class EnabledListener
{
    /**
     * @var \Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface
     */
    protected $tokenStorage;

    /**
     * @var \Ds\Component\Security\Voter\EnabledVoter
     */
    protected $enabledVoter;

    /**
     * Constructor
     *
     * @param \Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface $tokenStorage
     * @param \Ds\Component\Security\Voter\EnabledVoter $enabledVoter
     */
    public function __construct(TokenStorageInterface $tokenStorage, EnabledVoter $enabledVoter)
    {
        $this->tokenStorage = $tokenStorage;
        $this->enabledVoter = $enabledVoter;
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

        if (!in_array(Enableable::class, class_implements($entity), true)) {
            return;
        }

        $data = $request->attributes->get('data');

        if ($data instanceof Paginator || is_array($data)) {
            foreach ($data as $item) {
                $vote = $this->enabledVoter->vote($token, $item, ['*']);

                if (EnabledVoter::ACCESS_ABSTAIN === $vote) {
                    throw new LogicException('Voter cannot abstain from voting.');
                }

                if (EnabledVoter::ACCESS_GRANTED !== $vote) {
                    throw new AccessDeniedException('Access denied.');
                }
            }
        } else {
            $vote = $this->enabledVoter->vote($token, $data, ['*']);

            if (EnabledVoter::ACCESS_ABSTAIN === $vote) {
                throw new LogicException('Voter cannot abstain from voting.');
            }

            if (EnabledVoter::ACCESS_GRANTED !== $vote) {
                throw new AccessDeniedException('Access denied.');
            }
        }
    }
}
