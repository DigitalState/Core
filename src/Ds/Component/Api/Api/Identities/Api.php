<?php

namespace Ds\Component\Api\Api\Identities;

use GuzzleHttp\ClientInterface;
use Ds\Component\Api\Service\Identities;

/**
 * Class Api
 */
class Api
{
    /**
     * @var \Ds\Component\Api\Service\Identities\IndividualService
     */
    public $individual;

    /**
     * Constructor
     *
     * @param \GuzzleHttp\ClientInterface $client
     * @param string $host
     */
    public function __construct(ClientInterface $client, $host = null)
    {
        $this->individual = new Identities\IndividualService($client, $host);
        $this->staff = new Identities\StaffService($client, $host);
    }

    /**
     * Set host
     *
     * @param string $host
     * @return \Ds\Component\Api\Api\Identities\Api
     */
    public function setHost($host)
    {
        $this->individual->setHost($host);
        $this->staff->setHost($host);

        return $this;
    }
}
