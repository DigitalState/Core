<?php

namespace Ds\Component\Model\Attribute;

/**
 * Trait State
 */
trait State
{
    use Accessor\State;

    /**
     * @var integer
     */
    protected $state;
}
