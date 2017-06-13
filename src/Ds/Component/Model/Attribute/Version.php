<?php

namespace Ds\Component\Model\Attribute;

/**
 * Trait Version
 */
trait Version
{
    use Accessor\Version;

    /**
     * @var integer
     */
    protected $version;
}
