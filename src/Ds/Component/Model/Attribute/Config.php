<?php

namespace Ds\Component\Model\Attribute;

/**
 * Trait Config
 *
 * @package Ds\Component\Model
 */
trait Config
{
    use Accessor\Config;

    /**
     * @var array
     */
    protected $config;
}
