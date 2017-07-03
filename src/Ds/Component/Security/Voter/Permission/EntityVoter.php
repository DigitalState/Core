<?php

namespace Ds\Component\Security\Voter\Permission;

use Ds\Component\Security\Collection\PermissionCollection;
use Ds\Component\Security\Service\PermissionService;
use Ds\Component\Security\User\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

/**
 * Class EntityVoter
 */
class EntityVoter extends Voter
{
    /**
     * @const string
     */
    const BROWSE = 'BROWSE';
    const READ = 'READ';
    const ADD = 'ADD';
    const EDIT = 'EDIT';
    const DELETE = 'DELETE';

    /**
     * @var \Ds\Component\Security\Collection\PermissionCollection
     */
    protected $permissionCollection;

    /**
     * @var \Ds\Component\Security\Service\PermissionService
     */
    protected $permissionService;

    /**
     * Constructor
     *
     * @param \Ds\Component\Security\Collection\PermissionCollection $permissionCollection
     * @param \Ds\Component\Security\Service\PermissionService $permissionService
     */
    public function __construct(PermissionCollection $permissionCollection, PermissionService $permissionService)
    {
        $this->permissionCollection = $permissionCollection;
        $this->permissionService = $permissionService;
    }

    /**
     * {@inheritdoc}
     */
    protected function supports($attribute, $subject)
    {
        if (!in_array($attribute, [static::BROWSE, static::READ, static::ADD, static::EDIT, static::DELETE], true)) {
            return false;
        }

        if (!is_string($subject)) {
            return false;
        }

        if ('entity:' !== substr($subject, '0', 7)) {
            return false;
        }

        return true;
    }

    /**
     * {@inheritdoc}
     */
    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();

        if (!$user instanceof User) {
            return false;
        }

        return true;
    }
}
