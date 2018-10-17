<?php

namespace Ds\Component\Entity\Service;

/**
 * Class SequenceService
 *
 * @package Ds\Component\Entity
 */
class SequenceService
{
    /**
     * Constructor
     */
    public function __construct()
    {

    }

    public function create()
    {
        return uniqid();
    }
}
