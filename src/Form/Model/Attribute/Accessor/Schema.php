<?php

namespace Ds\Component\Form\Model\Attribute\Accessor;

/**
 * Trait Schema
 *
 * @package Ds\Component\Form
 */
trait Schema
{
    /**
     * Set schema
     *
     * @param array $schema
     * @return object
     */
    public function setSchema(?array $schema)
    {
        $this->schema = $schema;

        return $this;
    }

    /**
     * Get schema
     *
     * @return \stdClass|array
     */
    public function getSchema(): ?array
    {
        return $this->schema;
    }
}
