<?php

namespace Ds\Component\Security\Voter\Permission;

use Ds\Component\Security\Model\Permission;

/**
 * Class PropertyVoter
 */
class PropertyVoter extends PermissionVoter
{
    /**
     * {@inheritdoc}
     */
    protected function supports($attribute, $subject)
    {
        if (!parent::supports($attribute, $subject)) {
            return false;
        }

        if (Permission::PROPERTY !== $subject['type']) {
            return false;
        }

        if (!in_array($attribute, [Permission::BROWSE, Permission::READ, Permission::EDIT], true)) {
            return false;
        }

        return true;
    }
}
