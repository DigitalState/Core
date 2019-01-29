<?php

namespace Ds\Component\Health\Service;

use Ds\Component\Health\Collection\CheckCollection;
use Ds\Component\Health\Exception\InvalidAliasException;
use Ds\Component\Health\Model\Statuses;

/**
 * Class HealthService
 *
 * @package Ds\Component\Health
 */
final class HealthService
{
    /**
     * @var \Ds\Component\Health\Collection\CheckCollection
     */
    private $checkCollection;

    /**
     * Constructor
     *
     * @param \Ds\Component\Health\Collection\CheckCollection $checkCollection
     */
    public function __construct(CheckCollection $checkCollection)
    {
        $this->checkCollection = $checkCollection;
    }

    /**
     * Run health checks
     *
     * @param string $alias
     * @return \Ds\Component\Health\Model\Statuses|\Ds\Component\Health\Model\Status
     * @throws \Ds\Component\Health\Exception\InvalidAliasException
     */
    public function check($alias = null)
    {
        if (null === $alias) {
            $statuses = new Statuses;
            $statuses->setHealthy(true);

            foreach ($this->checkCollection as $check) {
                $status = $check->execute();
                $statuses->getCollection()->add($status);

                if (!$status->getHealthy()) {
                    $statuses->setHealthy(false);
                }
            }

            return $statuses;
        } else {
            $check = $this->checkCollection->filter(function($element) use($alias) {
                return $element->getAlias() === $alias;
            })->first();

            if (!$check) {
                throw new InvalidAliasException('Check alias does not exist.');
            }

            $status = $check->execute();

            return $status;
        }
    }
}
