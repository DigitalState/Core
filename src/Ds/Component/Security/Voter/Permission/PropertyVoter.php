<?php

namespace Ds\Component\Security\Voter\Permission;

use Doctrine\Common\Cache\Cache;
use Ds\Component\Security\Collection\PermissionCollection;
use Ds\Component\Security\Model\Permission;
use Ds\Component\Security\Service\PermissionService;
use Ds\Component\Security\User\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use UnexpectedValueException;

/**
 * Class PropertyVoter
 */
class PropertyVoter extends Voter
{
    /**
     * @var \Ds\Component\Security\Collection\PermissionCollection
     */
    protected $permissionCollection;

    /**
     * @var \Ds\Component\Security\Service\PermissionService
     */
    protected $permissionService;

    /**
     * @var \Doctrine\Common\Cache\Cache
     */
    protected $queryCache;

    /**
     * Constructor
     *
     * @param \Ds\Component\Security\Collection\PermissionCollection $permissionCollection
     * @param \Ds\Component\Security\Service\PermissionService $permissionService
     * @param \Doctrine\Common\Cache\Cache
     */
    public function __construct(PermissionCollection $permissionCollection, PermissionService $permissionService, Cache $queryCache)
    {
        $this->permissionCollection = $permissionCollection;
        $this->permissionService = $permissionService;
        $this->queryCache = $queryCache;
    }

    /**
     * {@inheritdoc}
     */
    protected function supports($attribute, $subject)
    {
        if (!in_array($attribute, [Permission::BROWSE, Permission::READ, Permission::EDIT], true)) {
            return false;
        }

        if (!is_string($subject)) {
            return false;
        }

        if (Permission::PROPERTY.':' !== substr($subject, '0', 9)) {
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

        // @todo Add doctrine cache
        $permission = $this->permissionService->getRepository()->findOneBy([
            'identity' => $user->getIdentity(),
            'identityUuid' => $user->getIdentityUuid()
        ]);

        if (!$permission) {
            return false;
        }

        $subject = substr($subject, 9);
        $granted = false;

        foreach ($permission->getEntries() as $entry) {
            $item = $this->permissionCollection->get($entry->getKey());

            if (!$item) {
                throw new UnexpectedValueException('Permission does not exist.');
            }

            if (Permission::PROPERTY !== $item['type']) {
                continue;
            }

            if ($subject !== $item['subject']) {
                continue;
            }

            if (in_array($attribute, $entry->getAttributes(), true)) {
                $granted = true;
                break;
            }
        }

        return $granted;
    }
}
