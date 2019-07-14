<?php

namespace Ds\Component\Api\Model\Attribute;

/**
 * Trait Scope
 *
 * @package Ds\Component\Api
 */
trait Scope
{
    use Accessor\Scope;

    /**
     * @var \Ds\Component\Api\Model\Scope
     */
    private $scope;
}
