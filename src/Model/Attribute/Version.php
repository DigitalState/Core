<?php

namespace Ds\Component\Model\Attribute;

/**
 * Trait Version
 *
 * @package Ds\Component\Model
 */
trait Version
{
    use Accessor\Version;

    /**
     * @var integer
     */
    protected $version;
}
