<?php

namespace Ds\Component\Security\Test\Collection;

use Doctrine\Common\Collections\ArrayCollection;
use Ds\Component\Security\Model\User;
use InvalidArgumentException;

/**
 * Class UserCollection
 *
 * @package Ds\Component\Security
 */
final class UserCollection extends ArrayCollection
{
    /**
     * {@inheritdoc}
     */
    public function __construct(array $elements = [])
    {
        foreach ($elements as $key => $element) {
            $elements[$key] = $this->cast($element);
        }

        parent::__construct($elements);
    }

    /**
     * {@inheritdoc}
     */
    public function removeElement($element)
    {
        $element = $this->cast($element);

        return parent::removeElement($element);
    }

    /**
     * {@inheritDoc}
     */
    public function contains($element)
    {
        $element = $this->cast($element);

        return parent::contains($element);
    }

    /**
     * {@inheritDoc}
     */
    public function indexOf($element)
    {
        $element = $this->cast($element);

        return parent::indexOf($element);
    }

    /**
     * {@inheritDoc}
     */
    public function set($key, $element)
    {
        $element = $this->cast($element);

        return parent::set($key, $element);
    }

    /**
     * {@inheritDoc}
     */
    public function add($element)
    {
        $element = $this->cast($element);

        return parent::add($element);
    }

    /**
     * Cast element to user identity object
     *
     * @param mixed $element
     * @return \Ds\Component\Security\Model\User
     * @throws \InvalidArgumentException
     */
    protected function cast($element) {
        if ($element instanceof User) {
            return $element;
        }

        if (!is_array($element)) {
            throw new InvalidArgumentException('Element is not an array.');
        }

        foreach (['username', 'roles', 'business_units', 'uuid', 'identity', 'tenant'] as $key) {
            if (!array_key_exists($key, $element)) {
                throw new InvalidArgumentException('Element is missing key "'.$key.'".');
            }
        }

        $element['identity'] = (object) $element['identity'];
        $user = User::createFromPayload($element['username'], $element);

        return $user;
    }
}
