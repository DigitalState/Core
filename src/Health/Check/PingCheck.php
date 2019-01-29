<?php

namespace Ds\Component\Health\Check;

use Ds\Component\Health\Model\Status;
use Ds\Component\Model\Attribute;

/**
 * Class PingCheck
 *
 * @package Ds\Component\Health
 */
final class PingCheck implements Check
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
