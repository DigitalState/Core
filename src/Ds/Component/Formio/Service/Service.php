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
     * Set headers
     *
     * @param array $headers
     * @return \Ds\Component\Formio\Service\Service
     */
    public function setHeaders(array $headers = []);

    /**
     * Set header
     *
     * @param string $name
     * @param string $value
     * @return \Ds\Component\Formio\Service\Service
     */
    public function setHeader($name, $value);
}
