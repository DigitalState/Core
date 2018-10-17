<?php

namespace Ds\Component\Func\Func;

/**
 * Interface Func
 *
 * @package Ds\Component\Func
 */
interface Func
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
     * Execute a func
     */
    public function execute();
}
