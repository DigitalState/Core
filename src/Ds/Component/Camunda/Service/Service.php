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
     * Set authorization
     *
     * @param array $authorization
     * @return \Ds\Component\Camunda\Service\Service
     */
    public function setAuthorization(array $authorization = []);
}
