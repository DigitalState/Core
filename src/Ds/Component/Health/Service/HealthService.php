<?php

namespace Ds\Component\Health\Service;

use Ds\Component\Health\Collection\CheckCollection;
use Ds\Component\Health\Model\Statuses;

/**
 * Class HealthService
 *
 * @package Ds\Component\Health
 */
class HealthService
{
    /**
     * @var \Ds\Component\Health\Collection\CheckCollection
     */
    protected $checkCollection;

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
     */
    public function check($alias = null)
    {
        if (null === $alias) {
            $statuses = new Statuses;
            $statuses->setHealthy(true);

            foreach ($this->checkCollection as $alias => $check) {
                $status = $check->execute();
                $statuses->getCollection()->set($alias, $status);

                if (!$status->getHealthy()) {
                    $statuses->setHealthy(false);
                }
            }

            return $statuses;
        } else {
            $status = $this->checkCollection->get($alias)->execute();

            return $status;
        }
    }
}
