<?php

namespace Ds\Component\Statistic\Stat;

/**
 * Interface Stat
 *
 * @package Ds\Component\Statistic
 */
interface Stat
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
     * Get stat datum
     *
     * @return \Ds\Component\Statistic\Model\Datum
     */
    public function get();
}
