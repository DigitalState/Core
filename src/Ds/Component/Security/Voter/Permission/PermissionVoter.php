<?php

namespace Ds\Component\Security\Voter\Permission;

use Doctrine\Common\Collections\ArrayCollection;
use Ds\Component\Security\Model\Subject;
use Ds\Component\Security\Service\AccessService;
use Ds\Component\Security\User\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

/**
 * Class PermissionVoter
 */
abstract class PermissionVoter extends Voter
{
    /**
     * @var \Ds\Component\Security\Service\AccessService
     */
    protected $accessService;

    /**
     * Constructor
     *
     * @param \Ds\Component\Security\Service\AccessService $accessService
     */
    public function __construct(AccessService $accessService)
    {
        $this->accessService = $accessService;
    }

    /**
     * {@inheritdoc}
     */
    protected function supports($attribute, $subject)
    {
        if (!$subject instanceof Subject) {
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

        $permissions = $this->getPermissions($user)->filter(function($permission) use ($subject) {
            if ($subject->getType() !== $permission->getType()) {
                return false;
            }

            if (!fnmatch($permission->getValue(), $subject->getValue(), FNM_NOESCAPE)) {
                return false;
            }

            if ($subject->getEntity() !== $permission->getEntity()) {
                return false;
            }

            if (null !== $permission->getEntityUuid()) {
                if ($subject->getEntityUuid() !== $permission->getEntityUuid()) {
                    return false;
                }
            }

            return true;
        });

        foreach ($permissions as $permission) {
            if (in_array($attribute, $permission->getAttributes(), true)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get user permissions
     *
     * @param \Ds\Component\Security\User\User $user
     * @return ArrayCollection
     */
    protected function getPermissions(User $user)
    {
        $permissions = new ArrayCollection;

        $accesses = $this->accessService->getRepository()->findBy([
            'identity' => $user->getIdentity(),
            'identityUuid' => null
        ]);

        foreach ($accesses as $access) {
            foreach ($access->getPermissions() as $permission) {
                $permissions->add($permission);
            }
        }

        $accesses = $this->accessService->getRepository()->findBy([
            'identity' => $user->getIdentity(),
            'identityUuid' => $user->getIdentityUuid()
        ]);

        foreach ($accesses as $access) {
            foreach ($access->getPermissions() as $permission) {
                $permissions->add($permission);
            }
        }

        return $permissions;
    }
}
