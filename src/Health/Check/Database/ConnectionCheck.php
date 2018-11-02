<?php

namespace Ds\Component\Health\Check\Database;

use Ds\Component\Health\Check\Check;
use Ds\Component\Health\Model\Status;
use Ds\Component\Model\Attribute;

/**
 * Class ConnectionCheck
 *
 * @package Ds\Component\Health
 */
final class ConnectionCheck implements Check
{
    use Attribute\Alias;

    /**
     * {@inheritdoc}
     */
    public function execute(): Status
    {
        $status = new Status;
        $status
            ->setAlias($this->alias)
            ->setHealthy(true);

        return $status;
    }
}
