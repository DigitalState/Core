<?php

namespace Ds\Component\Api\Api;

use Ds\Component\Api\Service;
use GuzzleHttp\ClientInterface;

/**
 * Class Api
 *
 * @package Ds\Component\Api
 */
class Api
{
    /**
     * @var \Ds\Component\Api\Service\HealthService
     */
    protected $health;

    /**
     * @var \Ds\Component\Api\Service\ConfigService
     */
    protected $config;

    /**
     * @var \Ds\Component\Api\Service\AccessService
     */
    protected $access;

    /**
     * @var \Ds\Component\Api\Service\PermissionService
     */
    protected $permission;

    /**
     * @var \Ds\Component\Api\Service\UserService
     */
    protected $user;

    /**
     * @var \Ds\Component\Api\Service\AdminService
     */
    protected $admin;

    /**
     * @var \Ds\Component\Api\Service\AnonymousService
     */
    protected $anonymous;

    /**
     * @var \Ds\Component\Api\Service\StaffService
     */
    protected $staff;

    /**
     * @var \Ds\Component\Api\Service\IndividualService
     */
    protected $individual;

    /**
     * @var \Ds\Component\Api\Service\SystemService
     */
    protected $system;

    /**
     * @var \Ds\Component\Api\Service\BusinessUnitService
     */
    protected $businessUnit;

    /**
     * @var \Ds\Component\Api\Service\CaseService
     */
    protected $case;

    /**
     * @var \Ds\Component\Api\Service\CaseStatusService
     */
    protected $caseStatus;

    /**
     * @var \Ds\Component\Api\Service\AssetService
     */
    protected $asset;

    /**
     * @var \Ds\Component\Api\Service\RecordService
     */
    protected $record;

    /**
     * @var \Ds\Component\Api\Service\CategoryService
     */
    protected $category;

    /**
     * @var \Ds\Component\Api\Service\ServiceService
     */
    protected $service;

    /**
     * @var \Ds\Component\Api\Service\ScenarioService
     */
    protected $scenario;

    /**
     * @var \Ds\Component\Api\Service\SubmissionService
     */
    protected $submission;

    /**
     * @var \Ds\Component\Api\Service\DataService
     */
    protected $data;

    /**
     * @var \Ds\Component\Api\Service\FileService
     */
    protected $file;

    /**
     * @var \Ds\Component\Api\Service\TextService
     */
    protected $text;

    /**
     * Constructor
     *
     * @param \GuzzleHttp\ClientInterface $client
     * @param string $host
     */
    public function __construct(ClientInterface $client, $host = null)
    {
        $this->health = new Service\HealthService($client, $host);
        $this->config = new Service\ConfigService($client, $host);
        $this->access = new Service\AccessService($client, $host);
        $this->permission = new Service\PermissionService($client, $host);
        $this->user = new Service\UserService($client, $host);
        $this->admin = new Service\AdminService($client, $host);
        $this->anonymous = new Service\AnonymousService($client, $host);
        $this->staff = new Service\StaffService($client, $host);
        $this->individual = new Service\IndividualService($client, $host);
        $this->system = new Service\SystemService($client, $host);
        $this->businessUnit = new Service\BusinessUnitService($client, $host);
        $this->case = new Service\CaseService($client, $host);
        $this->caseStatus = new Service\CaseStatusService($client, $host);
        $this->asset = new Service\AssetService($client, $host);
        $this->record = new Service\RecordService($client, $host);
        $this->category = new Service\CategoryService($client, $host);
        $this->service = new Service\ServiceService($client, $host);
        $this->scenario = new Service\ScenarioService($client, $host);
        $this->submission = new Service\SubmissionService($client, $host);
        $this->data = new Service\DataService($client, $host);
        $this->file = new Service\FileService($client, $host);
        $this->text = new Service\TextService($client, $host);
    }

    /**
     * Set host
     *
     * @param string $host
     * @return \Ds\Component\Api\Api\Api
     */
    public function setHost($host)
    {
        $this->health->setHost($host);
        $this->config->setHost($host);
        $this->access->setHost($host);
        $this->permission->setHost($host);
        $this->user->setHost($host);
        $this->admin->setHost($host);
        $this->anonymous->setHost($host);
        $this->staff->setHost($host);
        $this->individual->setHost($host);
        $this->system->setHost($host);
        $this->businessUnit->setHost($host);
        $this->case->setHost($host);
        $this->caseStatus->setHost($host);
        $this->asset->setHost($host);
        $this->record->setHost($host);
        $this->category->setHost($host);
        $this->service->setHost($host);
        $this->scenario->setHost($host);
        $this->submission->setHost($host);
        $this->data->setHost($host);
        $this->file->setHost($host);
        $this->text->setHost($host);

        return $this;
    }
}
