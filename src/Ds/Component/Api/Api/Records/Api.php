<?php

namespace Ds\Component\Api\Api\Records;

use Ds\Component\Api\Service\Records;
use GuzzleHttp\ClientInterface;

/**
 * Class Api
 *
 * @package Ds\Component\Api
 */
class Api
{
    /**
     * @var \Ds\Component\Api\Service\Records\RecordService
     */
    public $record;

    /**
     * Constructor
     *
     * @param \GuzzleHttp\ClientInterface $client
     * @param string $host
     */
    public function __construct(ClientInterface $client, $host = null)
    {
        $this->record = new Records\RecordService($client, $host);
    }

    /**
     * Set host
     *
     * @param string $host
     * @return \Ds\Component\Api\Api\Records\Api
     */
    public function setHost($host)
    {
        $this->record->setHost($host);

        return $this;
    }
}
