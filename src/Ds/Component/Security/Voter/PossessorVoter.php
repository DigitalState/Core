<?php

namespace Ds\Component\Security\Voter;

use Ds\Component\Identity\Identity;
use Ds\Component\Model\Type\Possessable;
use Ds\Component\Security\User\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

/**
 * Class PossessorVoter
 *
 * @package Ds\Component\Security
 */
class PossessorVoter extends Voter
{
    /**
     * {@inheritdoc}
     */
    protected function supports($attribute, $subject)
    {
        if (!$subject instanceof Possessable) {
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

        if ($user->getIdentity() !== $subject->getPossessor()) {
            return false;
        }

        if ($user->getIdentityUuid() !== $subject->getPossessorUuid()) {
            return false;
        }

        return true;
    }
}
