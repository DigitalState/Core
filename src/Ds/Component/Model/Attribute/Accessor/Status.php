<?php

namespace Ds\Component\Model\Attribute\Accessor;

use ReflectionClass;
use DomainException;

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
        if (!in_array($status, $this->getStatuses(), true)) {
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
    protected function getStatuses()
    {
        static $statuses = null;

        if (null === $statuses) {
            $statuses = [];
            $reflection = new ReflectionClass($this);

            foreach ($reflection->getConstants() as $constant => $value) {
                if ('STATUS_' === substr($constant, 0, 7)) {
                    $statuses[] = $value;
                }
            }
        }

        return $statuses;
    }
}
