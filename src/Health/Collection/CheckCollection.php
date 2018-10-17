<?php

namespace Ds\Component\Health\Collection;

use Doctrine\Common\Collections\ArrayCollection;
use Ds\Component\Health\Check\Check;
use InvalidArgumentException;

/**
 * Class CheckCollection
 *
 * @package Ds\Component\Health
 */
class CheckCollection extends ArrayCollection
{
    /**
     * {@inheritdoc}
     */
    public function __construct(array $elements = [])
    {
        foreach ($elements as $element) {
            if (!$element instanceof Check) {
                throw new InvalidArgumentException('Element is not a check object.');
            }
        }

        parent::__construct($elements);
    }

    /**
     * {@inheritdoc}
     */
    public function removeElement($element)
    {
        if (!$element instanceof Check) {
            throw new InvalidArgumentException('Element is not a check object.');
        }

        return parent::removeElement($element);
    }

    /**
     * {@inheritDoc}
     */
    public function contains($element)
    {
        if (!$element instanceof Check) {
            throw new InvalidArgumentException('Element is not a check object.');
        }

        return parent::contains($element);
    }

    /**
     * {@inheritDoc}
     */
    public function indexOf($element)
    {
        if (!$element instanceof Check) {
            throw new InvalidArgumentException('Element is not a check object.');
        }

        return parent::indexOf($element);
    }

    /**
     * {@inheritDoc}
     */
    public function set($key, $value)
    {
        if (!$value instanceof Check) {
            throw new InvalidArgumentException('Element is not a check object.');
        }

        return parent::set($key, $value);
    }

    /**
     * {@inheritDoc}
     */
    public function add($element)
    {
        if (!$element instanceof Check) {
            throw new InvalidArgumentException('Element is not a check object.');
        }

        return parent::add($element);
    }
}
