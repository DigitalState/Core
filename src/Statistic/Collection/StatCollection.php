<?php

namespace Ds\Component\Statistic\Collection;

use Doctrine\Common\Collections\ArrayCollection;
use Ds\Component\Statistic\Stat\Stat;
use InvalidArgumentException;

/**
 * Class StatCollection
 *
 * @package Ds\Component\Statistic
 */
class StatCollection extends ArrayCollection
{
    /**
     * {@inheritdoc}
     */
    public function __construct(array $elements = [])
    {
        foreach ($elements as $element) {
            if (!$element instanceof Stat) {
                throw new InvalidArgumentException('Element is not a stat object.');
            }
        }

        parent::__construct($elements);
    }

    /**
     * {@inheritdoc}
     */
    public function removeElement($element)
    {
        if (!$element instanceof Stat) {
            throw new InvalidArgumentException('Element is not a stat object.');
        }

        return parent::removeElement($element);
    }

    /**
     * {@inheritDoc}
     */
    public function contains($element)
    {
        if (!$element instanceof Stat) {
            throw new InvalidArgumentException('Element is not a stat object.');
        }

        return parent::contains($element);
    }

    /**
     * {@inheritDoc}
     */
    public function indexOf($element)
    {
        if (!$element instanceof Stat) {
            throw new InvalidArgumentException('Element is not a stat object.');
        }

        return parent::indexOf($element);
    }

    /**
     * {@inheritDoc}
     */
    public function set($key, $value)
    {
        if (!$value instanceof Stat) {
            throw new InvalidArgumentException('Element is not a stat object.');
        }

        return parent::set($key, $value);
    }

    /**
     * {@inheritDoc}
     */
    public function add($element)
    {
        if (!$element instanceof Stat) {
            throw new InvalidArgumentException('Element is not a stat object.');
        }

        return parent::add($element);
    }
}
