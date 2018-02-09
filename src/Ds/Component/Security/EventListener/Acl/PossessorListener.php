<?php

namespace Ds\Component\Security\EventListener\Acl;

use ApiPlatform\Core\DataProvider\PaginatorInterface as Paginator;
use Ds\Component\Model\Type\Possessable;
use Ds\Component\Security\Voter\PossessorVoter;
use LogicException;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Class PossessorListener
 *
 * @package Ds\Component\Security
 */
class PossessorListener
{
    /**
     * @var \Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface
     */
    protected $tokenStorage;

    /**
     * @var \Ds\Component\Security\Voter\PossessorVoter
     */
    protected $possessorVoter;

    /**
     * Constructor
     *
     * @param \Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface $tokenStorage
     * @param \Ds\Component\Security\Voter\PossessorVoter $possessorVoter
     */
    public function __construct(TokenStorageInterface $tokenStorage, PossessorVoter $possessorVoter)
    {
        $this->tokenStorage = $tokenStorage;
        $this->possessorVoter = $possessorVoter;
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

        if (!in_array(Possessable::class, class_implements($entity), true)) {
            return;
        }

        $data = $request->attributes->get('data');

        if ($data instanceof Paginator || is_array($data)) {
            foreach ($data as $item) {
                $vote = $this->possessorVoter->vote($token, $item, ['*']);

                if (PossessorVoter::ACCESS_ABSTAIN === $vote) {
                    throw new LogicException('Voter cannot abstain from voting.');
                }

                if (PossessorVoter::ACCESS_GRANTED !== $vote) {
                    throw new AccessDeniedException('Access denied.');
                }
            }
        } else {
            $vote = $this->possessorVoter->vote($token, $data, ['*']);

            if (PossessorVoter::ACCESS_ABSTAIN === $vote) {
                throw new LogicException('Voter cannot abstain from voting.');
            }

            if (PossessorVoter::ACCESS_GRANTED !== $vote) {
                throw new AccessDeniedException('Access denied.');
            }
        }
    }
}
