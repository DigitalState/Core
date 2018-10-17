<?php

namespace Ds\Component\Model\Attribute\Accessor;

use DomainException;
use ReflectionClass;

/**
 * Trait Type
 *
 * @package Ds\Component\Model
 */
trait Type
{
    /**
     * Set type
     *
     * @param string $type
     * @return object
     */
    public function setType($type)
    {
        if ($this->getTypes() && !in_array($type, $this->getTypes(), true)) {
            throw new DomainException('Type does not exist.');
        }

        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Get types
     *
     * @return array
     */
    public function getTypes()
    {
        static $types;

        if (null === $types) {
            $types = [];
            $class = new ReflectionClass($this);

            foreach ($class->getConstants() as $constant => $value) {
                if ('TYPE_' === substr($constant, 0, 5)) {
                    $types[] = $value;
                }
            }
        }

        return $types;
    }
}
