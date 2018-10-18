<?php

namespace Ds\Component\Model\Attribute;

/**
 * Trait Enabled
 *
 * @package Ds\Component\Model
 */
trait Enabled
{
    use Accessor\Enabled;

    /**
     * @var boolean
     */
    private $enabled;
}
