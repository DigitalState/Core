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
     * Set alias
     *
     * @param string $alias
     * @return object
     */
    public function setAlias($alias);

    /**
     * Get alias
     *
     * @return string
     */
    public function getAlias();

    /**
     * Execute an health check
     *
     * @return \Ds\Component\Health\Model\Status
     */
    public function execute();
}
