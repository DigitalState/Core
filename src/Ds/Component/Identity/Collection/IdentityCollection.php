<?php

namespace Ds\Component\Identity\Collection;

use Doctrine\Common\Collections\ArrayCollection;
use Ds\Component\Security\User\User;
use InvalidArgumentException;

/**
 * Class IdentityCollection
 *
 * @package Ds\Component\Identity
 */
class IdentityCollection extends ArrayCollection
{
    /**
     * {@inheritdoc}
     */
    public function __construct(array $identities = [])
    {
        foreach ($identities as $key => $identity) {
            $identities[$key] = $this->cast($identity);
        }

        parent::__construct($identities);
    }

    /**
     * {@inheritdoc}
     */
    public function removeElement($identity)
    {
        $identity = $this->cast($identity);

        return parent::removeElement($identity);
    }

    /**
     * {@inheritDoc}
     */
    public function contains($identity)
    {
        $identity = $this->cast($identity);

        return parent::contains($identity);
    }

    /**
     * {@inheritDoc}
     */
    public function indexOf($identity)
    {
        $identity = $this->cast($identity);

        return parent::indexOf($identity);
    }

    /**
     * {@inheritDoc}
     */
    public function set($key, $identity)
    {
        $identity = $this->cast($identity);

        return parent::set($key, $identity);
    }

    /**
     * {@inheritDoc}
     */
    public function add($identity)
    {
        $identity = $this->cast($identity);

        return parent::add($identity);
    }

    /**
     * Cast element to user identity object
     *
     * @param $element
     * @return \Ds\Component\Security\User\User
     * @throws \InvalidArgumentException
     */
    protected function cast($element) {
        if ($element instanceof User) {
            return $element;
        }

        if (!is_array($element)) {
            throw new InvalidArgumentException('Element is not an array.');
        }

        foreach (['username', 'uuid', 'roles', 'identity', 'identityUuid'] as $key) {
            if (!array_key_exists($key, $element)) {
                throw new InvalidArgumentException('Element is missing key "'.$key.'".');
            }
        }

        $user = User::createFromPayload($element['username'], $element);

        return $user;
    }
}
