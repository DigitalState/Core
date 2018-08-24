<?php

namespace Ds\Component\Model\Attribute;

/**
 * Trait Id
 *
 * @package Ds\Component\Model
 */
trait Id
{
    use Accessor\Id;

    /**
     * @var string
     */
    protected $id;
}
