<?php

namespace Ds\Component\Health\Check;

use Ds\Component\Health\Model\Status;

/**
 * Class PingCheck
 *
 * @package Ds\Component\Health
 */
class PingCheck implements Check
{
    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        $status = new Status;
        $status
            ->setAlias('ping')
            ->setHealthy(true);

        return $status;
    }
}
