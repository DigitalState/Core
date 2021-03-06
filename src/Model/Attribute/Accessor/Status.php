<?php

namespace Ds\Component\Model\Attribute\Accessor;

use DomainException;
use ReflectionClass;

/**
 * Trait Status
 *
 * @package Ds\Component\Model
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
    public function setStatus(?int $status)
    {
        if (null !== $status && $this->getStatuses() && !in_array($status, $this->getStatuses(), true)) {
            throw new DomainException('Status "'.$status.'" does not exist.');
        }

        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return integer
     */
    public function getStatus(): ?int
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
