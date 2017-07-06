<?php

namespace Ds\Component\Security\Voter\Permission;

use Ds\Component\Security\Model\Permission;

/**
 * Class EntityVoter
 */
class EntityVoter extends PermissionVoter
{
    /**
     * {@inheritdoc}
     */
    protected function supports($attribute, $subject)
    {
        if (!parent::supports($attribute, $subject)) {
            return false;
        }

        if (Permission::ENTITY !== $subject['type']) {
            return false;
        }

        if (!in_array($attribute, [Permission::BROWSE, Permission::READ, Permission::EDIT, Permission::ADD, Permission::DELETE], true)) {
            return false;
        }

        return true;
    }
}
