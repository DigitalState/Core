<?php

namespace Ds\Component\Model\Attribute;

/**
 * Trait PossessorUuid
 *
 * @package Ds\Component\Model
 */
trait PossessorUuid
{
    use Accessor\PossessorUuid;

    /**
     * @var string
     */
    protected $possessorUuid;
}
