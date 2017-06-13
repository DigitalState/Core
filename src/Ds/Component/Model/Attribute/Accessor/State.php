<?php

namespace Ds\Component\Model\Attribute\Accessor;

use ReflectionClass;
use DomainException;

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
        if (!in_array($state, $this->getStates(), true)) {
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
    protected function getStates()
    {
        static $states = null;

        if (null === $states) {
            $states = [];
            $reflection = new ReflectionClass($this);

            foreach ($reflection->getConstants() as $constant => $value) {
                if ('STATE_' === substr($constant, 0, 6)) {
                    $states[] = $value;
                }
            }
        }

        return $states;
    }
}
