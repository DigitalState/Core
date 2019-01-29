<?php

namespace Ds\Component\Form\Model\Attribute;

/**
 * Trait Schema
 *
 * @package Ds\Component\Form
 */
trait Schema
{
    use Accessor\Schema;

    /**
     * @var \stdClass|array
     */
    private $schema;
}
