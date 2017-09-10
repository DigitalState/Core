<?php

namespace Ds\Component\Security\Voter;

use Ds\Component\Identity\Identity;
use Ds\Component\Model\Type\Identitiable;
use Ds\Component\Security\User\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

/**
 * Class IdentityVoter
 *
 * @package Ds\Component\Security
 */
class IdentityVoter extends Voter
{
    /**
     * {@inheritdoc}
     */
    protected function supports($attribute, $subject)
    {
        if (!$subject instanceof Identitiable) {
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

        if (in_array($user->getIdentity(), [Identity::SYSTEM, Identity::STAFF], true)) {
            return true;
        }

        if ($user->getIdentity() !== $subject->getIdentity()) {
            return false;
        }

        if ($user->getIdentityUuid() !== $subject->getIdentityUuid()) {
            return false;
        }

        return true;
    }
}
