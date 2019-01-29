<?php

namespace Ds\Component\Health\Model\Attribute;

/**
 * Trait Healthy
 *
 * @package Ds\Component\Health
 */
trait Healthy
{
    use Accessor\Healthy;

    /**
     * @var boolean
     */
    private $healthy;
}
