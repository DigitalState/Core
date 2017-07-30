<?php

namespace Ds\Component\Security\Voter;

use Ds\Component\Security\Collection\PermissionCollection;
use Ds\Component\Security\Model\Permission;
use Ds\Component\Security\Model\Subject;
use Ds\Component\Security\Service\AccessService;
use Ds\Component\Security\User\User;
use InvalidArgumentException;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

/**
 * Class CustomVoter
 */
class CustomVoter extends Voter
{
    /**
     * @var \Ds\Component\Security\Service\AccessService
     */
    protected $accessService;

    /**
     * @var \Ds\Component\Security\Collection\PermissionCollection
     */
    protected $permissionCollection;

    /**
     * Constructor
     *
     * @param \Ds\Component\Security\Service\AccessService $accessService
     * @param \Ds\Component\Security\Collection\PermissionCollection $permissionCollection
     */
    public function __construct(AccessService $accessService, PermissionCollection $permissionCollection)
    {
        $this->accessService = $accessService;
        $this->permissionCollection = $permissionCollection;
    }

    /**
     * {@inheritdoc}
     */
    protected function supports($attribute, $subject)
    {
        try {
            $subject = $this->cast($subject);
        } catch (InvalidArgumentException $exception) {
            return false;
        }

        if (!$subject instanceof Subject) {
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

    /**
     * {@inheritdoc}
     */
    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $subject = $this->cast($subject);
        $user = $token->getUser();

        if (!$user instanceof User) {
            return false;
        }

        $permissions = $this->accessService->getCompiled($user)->filter(function($permission) use ($subject) {
            if ($subject->getType() !== $permission->getType()) {
                return false;
            }

            if (!fnmatch($permission->getValue(), $subject->getValue(), FNM_NOESCAPE)) {
                return false;
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
     * Cast subject to subject object
     *
     * @param mixed $subject
     * @return \Ds\Component\Security\Model\Subject
     * @throws \InvalidArgumentException
     */
    protected function cast($subject) {
        if ($subject instanceof Subject) {
            return $subject;
        }

        if (!is_string($subject)) {
            throw new InvalidArgumentException('Subject is not a string or object.');
        }

        $permission = $this->permissionCollection->get($subject);

        if (!$permission) {
            throw new InvalidArgumentException('Subject does not exist.');
        }

        if (Permission::CUSTOM !== $permission->getType()) {
            throw new InvalidArgumentException('Subject is a permission of type custom.');
        }

        $subject = new Subject;
        $subject
            ->setType($permission->getType())
            ->setValue($permission->getValue());

        return $subject;
    }
}
