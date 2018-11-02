<?php

namespace Ds\Component\Resolver\Resolver;

/**
 * Interface Resolver
 *
 * @package Ds\Component\Resolver
 */
interface Resolver
{
    /**
     * Check if variable pattern is a match
     *
     * @param string $variable
     * @return boolean
     */
    public function isMatch(string $variable): bool;

    /**
     * Resolve variable
     *
     * @param string $variable
     * @return mixed
     */
    public function resolve(string $variable);
}
