<?php

namespace Ds\Component\Camunda\Service;

/**
 * Interface Service
 *
 * @package Ds\Component\Camunda
 */
interface Service
{
    /**
     * Set host
     *
     * @param string $host
     * @return \Ds\Component\Camunda\Service\Service
     */
    public function setHost($host = null);

    /**
     * Set headers
     *
     * @param array $headers
     * @return \Ds\Component\Camunda\Service\Service
     */
    public function setHeaders(array $headers = []);

    /**
     * Set header
     *
     * @param string $name
     * @param string $value
     * @return \Ds\Component\Camunda\Service\Service
     */
    public function setHeader($name, $value);
}
