<?php

namespace Ds\Component\Log\Monolog\Processor;

/**
 * Class AppProcessor
 *
 * @package Ds\Log\Monolog
 */
class AppProcessor
{
    /**
     * @var string
     */
    protected $app;

    /**
     * Constructor
     *
     * @param string $app
     */
    public function __construct($app)
    {
        $this->app = $app;
    }

    /**
     * Process record
     *
     * @param array $record
     * @return array
     */
    public function process(array $record)
    {
        if (null !== $this->app) {
            $record['app'] = $this->app;
        }

        return $record;
    }
}
