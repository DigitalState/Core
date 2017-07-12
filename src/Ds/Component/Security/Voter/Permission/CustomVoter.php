<?php

namespace Ds\Component\Security\Voter\Permission;

use Ds\Component\Security\Model\Permission;

/**
 * Class CustomVoter
 */
class CustomVoter extends PermissionVoter
{
    /**
     * {@inheritdoc}
     */
    protected function supports($attribute, $subject)
    {
        if (!parent::supports($attribute, $subject)) {
            return false;
        }

        if (Permission::CUSTOM !== $subject->getType()) {
            return false;
        }

        if (!in_array($attribute, [Permission::BROWSE, Permission::READ, Permission::EDIT, Permission::ADD, Permission::DELETE, Permission::EXECUTE], true)) {
            return false;
        }

        return true;
    }
}
