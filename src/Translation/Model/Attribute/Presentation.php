<?php

namespace Ds\Component\Translation\Model\Attribute;

use Ds\Component\Translation\Model\Attribute\Accessor;

/**
 * Trait Presentation
 *
 * @package Ds\Component\Translation
 */
trait Presentation
{
    use Accessor\Presentation;

    /**
     * @var array
     */
    protected $presentation;
}
