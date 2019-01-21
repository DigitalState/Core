<?php

namespace Ds\Component\Model\Attribute;

/**
 * Trait State
 *
 * @package Ds\Component\Model
 */
trait State
{
    use Accessor\State;

    /**
     * @var integer
     */
    private $state;
}
