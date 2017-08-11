<?php

namespace Ds\Component\Resolver\Resolver\Resolver;

/**
 * Interface Resolver
 */
interface Resolver
{
    /**
     * Check if variable pattern is a match
     *
     * @param string $variable
     * @return boolean
     */
    public function isMatch($variable);

    /**
     * Resolve variable
     *
     * @param string $variable
     * @return mixed
     */
    public function resolve($variable);
}
