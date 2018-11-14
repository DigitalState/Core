<?php

namespace Ds\Component\System\Service;

/**
 * Interface Service
 *
 * @package Ds\Component\System
 */
interface Service
{
    /**
     * Set host
     *
     * @param string $host
     * @return \Ds\Component\System\Service\Service
     */
    public function setHost(string $host);

    /**
     * Set headers
     *
     * @param array $headers
     * @return \Ds\Component\System\Service\Service
     */
    public function setHeaders(array $headers);

    /**
     * Set header
     *
     * @param string $name
     * @param string $value
     * @return \Ds\Component\System\Service\Service
     */
    public function setHeader(string $name, string $value);
}
