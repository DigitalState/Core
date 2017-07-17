<?php

namespace Ds\Component\Health\Check\Database;

use Ds\Component\Health\Check\Check;
use Ds\Component\Health\Model\Status;

/**
 * Class ConnectionCheck
 *
 * @package Ds\Component\Health
 */
class ConnectionCheck implements Check
{
    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        $status = new Status;
        $status
            ->setAlias('database.connection')
            ->setHealthy(true);

        return $status;
    }
}
