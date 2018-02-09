<?php

namespace Ds\Component\Model\Attribute;

/**
 * Trait Possessor
 *
 * @package Ds\Component\Model
 */
trait Possessor
{
    use Accessor\Possessor;

    /**
     * @var string
     */
    protected $possessor;
}
