<?php

namespace Ds\Component\Api\Service;

/**
 * Interface Service
 *
 * @package Ds\Component\Api
 */
interface Service
{
    /**
     * Set host
     *
     * @param string $host
     * @return \Ds\Component\Api\Service\Service
     */
    public function setHost(string $host);

    /**
     * Set headers
     *
     * @param array $headers
     * @return \Ds\Component\Api\Service\Service
     */
    public function setHeaders(array $headers);

    /**
     * Set header
     *
     * @param string $name
     * @param string $value
     * @return \Ds\Component\Api\Service\Service
     */
    public function setHeader(string $name, string $value);
}
