<?php

namespace Ds\Component\Security\Voter;

use Ds\Component\Identity\Model\Identity;
use Ds\Component\Model\Type\Deletable;
use Ds\Component\Security\Model\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

/**
 * Class DeletedVoter
 *
 * @package Ds\Component\Security
 */
class DeletedVoter extends Voter
{
    /**
     * {@inheritdoc}
     */
    protected function supports($attribute, $subject)
    {
        if (!$subject instanceof Deletable) {
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

        if ($user instanceof \Symfony\Component\Security\Core\User\User && in_array('ROLE_SYSTEM', $user->getRoles())) {
            return true;
        }

        if (!$user instanceof User) {
            return false;
        }

        if (in_array($user->getIdentity()->getType(), [Identity::SYSTEM, Identity::STAFF], true)) {
            return true;
        }

        if (!$subject->getDeleted()) {
            return true;
        }

        return false;
    }
}
