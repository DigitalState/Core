<?php

namespace Ds\Component\Security\Model\Attribute;

/**
 * Trait Subject
 */
trait Subject
{
    use Accessor\Subject;

    /**
     * @var string
     */
    protected $subject;
}
