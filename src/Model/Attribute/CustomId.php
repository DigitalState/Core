<?php

namespace Ds\Component\Model\Attribute;

/**
 * Trait CustomId
 *
 * @package Ds\Component\Model
 */
trait CustomId
{
    use Accessor\CustomId;

    /**
     * @var string
     */
    private $customId;
}
