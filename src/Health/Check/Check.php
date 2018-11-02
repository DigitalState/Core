<?php

namespace Ds\Component\Health\Check;

use Ds\Component\Health\Model\Status;

/**
 * Interface Check
 *
 * @package Ds\Component\Health
 */
interface Check
{
    /**
     * Set alias
     *
     * @param string $alias
     * @return \Ds\Component\Health\Check\Check
     */
    public function setAlias(?string $alias);

    /**
     * Get alias
     *
     * @return string
     */
    public function getAlias(): ?string;

    /**
     * Execute an health check
     *
     * @return \Ds\Component\Health\Model\Status
     */
    public function execute(): Status;
}
