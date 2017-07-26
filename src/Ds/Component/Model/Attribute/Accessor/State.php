<?php

namespace Ds\Component\Model\Attribute\Accessor;

use DomainException;
use ReflectionClass;

/**
 * Trait State
 */
trait State
{
    /**
     * Set state
     *
     * @param integer $state
     * @return object
     * @throws \DomainException
     */
    public function setState($state)
    {
        if ($this->getStates() && !in_array($state, $this->getStates(), true)) {
            throw new DomainException('State does not exist.');
        }

        $this->state = $state;

        return $this;
    }

    /**
     * Get state
     *
     * @return integer
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Get states
     *
     * @return array
     */
    public function getStates()
    {
        static $states;

        if (null === $states) {
            $states = [];
            $class = new ReflectionClass($this);

            foreach ($class->getConstants() as $constant => $value) {
                if ('STATE_' === substr($constant, 0, 6)) {
                    $states[] = $value;
                }
            }
        }

        return $states;
    }
}
