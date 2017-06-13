<?php

namespace Ds\Component\Model\Attribute\Translation;

use Ds\Component\Model\Attribute\Accessor;

/**
 * Trait Presentation
 */
trait Presentation
{
    use Accessor\Translation\Presentation;

    /**
     * @var array
     */
    protected $presentation;
}
