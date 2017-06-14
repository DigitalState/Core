<?php

namespace Ds\Component\Model\Attribute\Accessor;

/**
 * Trait Schema
 */
trait Schema
{
    /**
     * Set schema
     *
     * @param \stdClass|array $schema
     * @return object
     */
    public function setSchema($schema)
    {
        $this->schema = $schema;

        return $this;
    }

    /**
     * Get schema
     *
     * @return \stdClass|array
     */
    public function getSchema()
    {
        return $this->schema;
    }
}
