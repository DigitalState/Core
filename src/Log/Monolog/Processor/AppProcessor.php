<?php

namespace Ds\Component\Log\Monolog\Processor;

/**
 * Class AppProcessor
 *
 * @package Ds\Component\Log
 */
final class AppProcessor
{
    /**
     * @var string
     */
    private $app;

    /**
     * Constructor
     *
     * @param string $app
     */
    public function __construct(?string $app)
    {
        $this->app = $app;
    }

    /**
     * Process record
     *
     * @param array $record
     * @return array
     */
    public function process(array $record): array
    {
        if (null !== $this->app) {
            $record['app'] = $this->app;
        }

        return $record;
    }
}
