<?php

namespace Ds\Component\Model\Attribute;

/**
 * Trait Scope
 *
 * @package Ds\Component\Model
 */
trait Scope
{
    use Accessor\Scope;

    /**
     * @var array
     */
    private $scope;
}
