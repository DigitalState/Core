<?php

namespace Ds\Component\Model\Attribute\Accessor;

use DomainException;
use ReflectionClass;

/**
 * Trait Status
 */
trait Status
{
    /**
     * Set status
     *
     * @param integer $status
     * @return object
     * @throws \DomainException
     */
    public function setStatus($status)
    {
        if ($this->getStatuses() && !in_array($status, $this->getStatuses(), true)) {
            throw new DomainException('Status does not exist.');
        }

        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return integer
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Get statuses
     *
     * @return array
     */
    public function getStatuses()
    {
        static $statuses;

        if (null === $statuses) {
            $statuses = [];
            $class = new ReflectionClass($this);

            foreach ($class->getConstants() as $constant => $value) {
                if ('STATUS_' === substr($constant, 0, 7)) {
                    $statuses[] = $value;
                }
            }
        }

        return $statuses;
    }
}
