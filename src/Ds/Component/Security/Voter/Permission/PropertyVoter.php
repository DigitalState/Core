<?php

namespace Ds\Component\Security\Voter\Permission;

use Doctrine\Common\Collections\ArrayCollection;
use Ds\Component\Security\Model\Permission;
use Ds\Component\Security\Service\AccessService;
use Ds\Component\Security\User\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

/**
 * Class PropertyVoter
 */
class PropertyVoter extends Voter
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
        if (!in_array($attribute, [Permission::BROWSE, Permission::READ, Permission::EDIT], true)) {
            return false;
        }

        if (!is_array($subject)) {
            return false;
        }

        if (!array_key_exists('entity', $subject)) {
            return false;
        }

        if (!array_key_exists('entity_uuid', $subject)) {
            return false;
        }

        if (!array_key_exists('type', $subject)) {
            return false;
        }

        if (Permission::PROPERTY !== $subject['type']) {
            return false;
        }

        if (!array_key_exists('subject', $subject)) {
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
            if ($subject['type'] !== $permission->getType()) {
                return false;
            }

            if ($subject['subject'] !== $permission->getSubject()) {
                return false;
            }

            if ($subject['entity'] !== $permission->getEntity()) {
                return false;
            }

            if (null !== $permission->getEntityUuid()) {
                if ($subject['entity_uuid'] !== $permission->getEntityUuid()) {
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

        $generic = $this->accessService->getRepository()->findOneBy([
            'identity' => $user->getIdentity(),
            'identityUuid' => null
        ]);

        if ($generic) {
            foreach ($generic->getPermissions() as $permission) {
                $permissions->add($permission);
            }
        }

        $specific = $this->accessService->getRepository()->findOneBy([
            'identity' => $user->getIdentity(),
            'identityUuid' => $user->getIdentityUuid()
        ]);

        if ($specific) {
            foreach ($specific->getPermissions() as $permission) {
                $permissions->add($permission);
            }
        }

        return $permissions;
    }
}
