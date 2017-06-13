<?php

namespace Ds\Component\Model\Attribute;

/**
 * Trait Enabled
 */
trait Enabled
{
    use Accessor\Enabled;

    /**
     * @var boolean
     */
    protected $enabled;
}
