<?php

namespace Ds\Component\Api\Api\Services;

use Ds\Component\Api\Service\Services;
use GuzzleHttp\ClientInterface;

/**
 * Class Api
 *
 * @package Ds\Component\Api
 */
class Api
{
    /**
     * @var \Ds\Component\Api\Service\Services\CategoryService
     */
    public $category;

    /**
     * @var \Ds\Component\Api\Service\Services\ScenarioService
     */
    public $scenario;

    /**
     * @var \Ds\Component\Api\Service\Services\ServiceService
     */
    public $service;

    /**
     * @var \Ds\Component\Api\Service\Services\SubmissionService
     */
    public $submission;

    /**
     * Constructor
     *
     * @param \GuzzleHttp\ClientInterface $client
     * @param string $host
     */
    public function __construct(ClientInterface $client, $host = null)
    {
        $this->category = new Services\CategoryService($client, $host);
        $this->scenario = new Services\ScenarioService($client, $host);
        $this->service = new Services\ServiceService($client, $host);
        $this->submission = new Services\SubmissionService($client, $host);
    }

    /**
     * Set host
     *
     * @param string $host
     * @return \Ds\Component\Api\Api\Services\Api
     */
    public function setHost($host)
    {
        $this->category->setHost($host);
        $this->scenario->setHost($host);
        $this->service->setHost($host);
        $this->submission->setHost($host);

        return $this;
    }
}
