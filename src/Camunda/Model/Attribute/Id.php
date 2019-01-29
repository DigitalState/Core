<?php

namespace Ds\Component\Camunda\Model\Attribute;

/**
 * Trait Id
 *
 * @package Ds\Component\Camunda
 */
trait Id
{
    /**
     * @var string
     */
    private $id; # region accessors

    /**
     * Set id
     *
     * @param string $id
     * @return object
     */
    public function setId(?string $id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get id
     *
     * @return string
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    # endregion
}
