<?php

namespace Ds\Component\Health\Check;

/**
 * Interface Check
 *
 * @package Ds\Component\Health
 */
interface Check
{
    /**
     * Execute an health check
     *
     * @return \Ds\Component\Health\Model\Status
     */
    public function execute();
}
