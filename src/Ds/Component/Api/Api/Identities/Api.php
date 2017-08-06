<?php

namespace Ds\Component\Api\Api\Identities;

use Ds\Component\Api\Service\Identities;
use GuzzleHttp\ClientInterface;

/**
 * Class Api
 *
 * @package Ds\Component\Api
 */
class Api
{
    /**
     * @var \Ds\Component\Api\Service\Identities\AdminService
     */
    public $admin;

    /**
     * @var \Ds\Component\Api\Service\Identities\AnonymousService
     */
    public $anonymous;

    /**
     * @var \Ds\Component\Api\Service\Identities\IndividualService
     */
    public $individual;

    /**
     * @var \Ds\Component\Api\Service\Identities\StaffService
     */
    public $staff;

    /**
     * @var \Ds\Component\Api\Service\Identities\SystemService
     */
    public $system;

    /**
     * Constructor
     *
     * @param \GuzzleHttp\ClientInterface $client
     * @param string $host
     */
    public function __construct(ClientInterface $client, $host = null)
    {
        $this->admin = new Identities\AdminService($client, $host);
        $this->anonymous = new Identities\AnonymousService($client, $host);
        $this->individual = new Identities\IndividualService($client, $host);
        $this->staff = new Identities\StaffService($client, $host);
        $this->system = new Identities\SystemService($client, $host);
    }

    /**
     * Set host
     *
     * @param string $host
     * @return \Ds\Component\Api\Api\Identities\Api
     */
    public function setHost($host)
    {
        $this->admin->setHost($host);
        $this->anonymous->setHost($host);
        $this->individual->setHost($host);
        $this->staff->setHost($host);
        $this->system->setHost($host);

        return $this;
    }
}
