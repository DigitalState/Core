<?php

namespace Ds\Component\Translation\Model\Attribute;

use Ds\Component\Translation\Model\Attribute\Accessor;

/**
 * Trait Presentation
 */
trait Presentation
{
    use Accessor\Presentation;

    /**
     * @var array
     */
    protected $presentation;
}
