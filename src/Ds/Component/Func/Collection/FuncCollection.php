<?php

namespace Ds\Component\Func\Collection;

use Doctrine\Common\Collections\ArrayCollection;
use Ds\Component\Func\Func\Func;
use InvalidArgumentException;

/**
 * Class FuncCollection
 *
 * @package Ds\Component\Func
 */
class FuncCollection extends ArrayCollection
{
    /**
     * {@inheritdoc}
     */
    public function __construct(array $elements = [])
    {
        foreach ($elements as $element) {
            if (!$element instanceof Func) {
                throw new InvalidArgumentException('Element is not a func object.');
            }
        }

        parent::__construct($elements);
    }

    /**
     * {@inheritdoc}
     */
    public function removeElement($element)
    {
        if (!$element instanceof Func) {
            throw new InvalidArgumentException('Element is not a func object.');
        }

        return parent::removeElement($element);
    }

    /**
     * {@inheritDoc}
     */
    public function contains($element)
    {
        if (!$element instanceof Func) {
            throw new InvalidArgumentException('Element is not a func object.');
        }

        return parent::contains($element);
    }

    /**
     * {@inheritDoc}
     */
    public function indexOf($element)
    {
        if (!$element instanceof Func) {
            throw new InvalidArgumentException('Element is not a func object.');
        }

        return parent::indexOf($element);
    }

    /**
     * {@inheritDoc}
     */
    public function set($key, $value)
    {
        if (!$value instanceof Func) {
            throw new InvalidArgumentException('Element is not a func object.');
        }

        return parent::set($key, $value);
    }

    /**
     * {@inheritDoc}
     */
    public function add($element)
    {
        if (!$element instanceof Func) {
            throw new InvalidArgumentException('Element is not a func object.');
        }

        return parent::add($element);
    }
}
