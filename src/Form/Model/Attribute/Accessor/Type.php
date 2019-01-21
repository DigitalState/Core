<?php

namespace Ds\Component\Form\Model\Attribute\Accessor;

use DomainException;
use ReflectionClass;

/**
 * Trait Type
 *
 * @package Ds\Component\Form
 */
trait Type
{
    /**
     * Set type
     *
     * @param string $type
     * @return object
     */
    public function setType(?string $type)
    {
        if (null !== $type && $this->getTypes() && !in_array($type, $this->getTypes(), true)) {
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
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * Get types
     *
     * @return array
     */
    public function getTypes(): array
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
