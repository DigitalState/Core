<?php

namespace Ds\Component\Security\Voter;

use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

/**
 * Class AuthorizationVoter
 */
class AuthorizationVoter extends Voter
{
    /**
     * @const string
     */
    const VIEW = 'view';
    const CREATE = 'create';
    const EDIT = 'edit';
    const DELETE = 'delete';

    /**
     * @var string
     */
    protected $entity;

    /**
     * @var \Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface
     */
    protected $decisionManager;

    /**
     * Constructor
     *
     * @param string $entity
     * @param \Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface $decisionManager
     */
    public function __construct($entity, AccessDecisionManagerInterface $decisionManager)
    {
        $this->entity = $entity;
        $this->decisionManager = $decisionManager;
    }

    /**
     * {@inheritdoc}
     */
    protected function supports($attribute, $subject)
    {
        return false;
    }

    /**
     * {@inheritdoc}
     */
    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        return false;
    }
}
