<?php

namespace Ds\Component\Formio\Service;

/**
 * Interface Service
 *
 * @package Ds\Component\Formio
 */
interface Service
{
    /**
     * Set host
     *
     * @param string $host
     * @return \Ds\Component\Formio\Service\Service
     */
    public function setHost($host = null);

    /**
     * Set authorization
     *
     * @param array $authorization
     * @return \Ds\Component\Formio\Service\Service
     */
    public function setAuthorization(array $authorization = []);
}
