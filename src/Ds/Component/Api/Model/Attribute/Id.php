<?php

namespace Ds\Component\Api\Model\Attribute;

/**
 * Trait Id
 *
 * @package Ds\Component\Api
 */
trait Id
{
    use Accessor\Id;

    /**
     * @var integer
     */
    protected $id;
}
