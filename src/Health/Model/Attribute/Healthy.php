<?php

namespace Ds\Component\Health\Model\Attribute;

/**
 * Trait Healthy
 */
trait Healthy
{
    use Accessor\Healthy;

    /**
     * @var boolean
     */
    protected $healthy;
}
