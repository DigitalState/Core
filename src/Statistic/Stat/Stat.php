<?php

namespace Ds\Component\Statistic\Stat;

use Ds\Component\Statistic\Model\Datum;

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
    public function setAlias(?string $alias);

    /**
     * Get alias
     *
     * @return string
     */
    public function getAlias(): ?string;

    /**
     * Get stat datum
     *
     * @return \Ds\Component\Statistic\Model\Datum
     */
    public function get(): Datum;
}
