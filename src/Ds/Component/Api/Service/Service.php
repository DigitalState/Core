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
    public function setHost($host = null);

    /**
     * Set headers
     *
     * @param array $headers
     * @return \Ds\Component\Api\Service\Service
     */
    public function setHeaders(array $headers = []);
}
