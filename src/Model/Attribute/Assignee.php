<?php

namespace Ds\Component\Model\Attribute;

/**
 * Trait Assignee
 *
 * @package Ds\Component\Model
 */
trait Assignee
{
    use Accessor\Assignee;

    /**
     * @var string
     */
    private $assignee;
}
