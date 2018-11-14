<?php

namespace Ds\Component\Identity\Voter;

use Ds\Component\Security\Model\Identity;
use Ds\Component\Model\Type\Enableable;
use Ds\Component\Security\Model\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

/**
 * Class EnabledVoter
 *
 * @package Ds\Component\Identity
 */
final class EnabledVoter extends Voter
{
    /**
     * {@inheritdoc}
     */
    protected function supports($attribute, $subject)
    {
        if (!$subject instanceof Enableable) {
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

        if (in_array($user->getIdentity()->getType(), [Identity::SYSTEM, Identity::STAFF], true)) {
            return true;
        }

        if ($subject->getEnabled()) {
            return true;
        }

        return false;
    }
}
