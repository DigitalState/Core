<?php

namespace Ds\Component\Formio\Api;

use GuzzleHttp\ClientInterface;
use Ds\Component\Formio\Service;

/**
 * Class Api
 *
 * @package Ds\Component\Formio
 */
class Api
{
    /**
     * @var \Ds\Component\Formio\Service\AuthenticationService
     */
    public $authentication;

    /**
     * @var \Ds\Component\Formio\Service\ProjectService
     */
    public $project;

    /**
     * @var \Ds\Component\Formio\Service\FormService
     */
    public $form;

    /**
     * @var \Ds\Component\Formio\Service\SubmissionService
     */
    public $submission;

    /**
     * @var \Ds\Component\Formio\Service\UserService
     */
    public $user;

    /**
     * Constructor
     *
     * @param \GuzzleHttp\ClientInterface $client
     * @param string $host
     * @param array $authorization
     */
    public function __construct(ClientInterface $client, $host = null, array $authorization = [])
    {
        $this->authentication = new Service\AuthenticationService($client, $host, $authorization);
        $this->project = new Service\ProjectService($client, $host, $authorization);
        $this->form = new Service\FormService($client, $host, $authorization);
        $this->submission = new Service\SubmissionService($client, $host, $authorization);
        $this->user = new Service\UserService($client, $host, $authorization);
    }

    /**
     * Set host
     *
     * @param string $host
     * @return \Ds\Component\Formio\Api\Api
     */
    public function setHost($host = null)
    {
        $this->authentication->setHost($host);
        $this->project->setHost($host);
        $this->form->setHost($host);
        $this->user->setHost($host);
        $this->submission->setHost($host);

        return $this;
    }

    /**
     * Set authorization
     *
     * @param array $authorization
     * @return \Ds\Component\Formio\Api\Api
     */
    public function setAuthorization(array $authorization = [])
    {
        $this->authentication->setAuthorization($authorization);
        $this->project->setAuthorization($authorization);
        $this->form->setAuthorization($authorization);
        $this->user->setAuthorization($authorization);
        $this->submission->setAuthorization($authorization);
    }
}
