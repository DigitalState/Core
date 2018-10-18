<?php

namespace Ds\Component\Model\Attribute;

/**
 * Trait Identifier
 *
 * @package Ds\Component\Model
 */
trait Identifier
{
    use Accessor\Identifier;

    /**
     * @var string
     */
    private $identifier;
}
