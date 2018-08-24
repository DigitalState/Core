<?php

namespace Ds\Component\Camunda\Service;

use Ds\Component\Camunda\Model\ProcessInstance;
use Ds\Component\Camunda\Query\ProcessInstanceParameters as Parameters;

/**
 * Class ProcessInstanceService
 *
 * @package Ds\Component\Camunda
 */
class ProcessInstanceService extends AbstractService
{
    /**
     * @const string
     */
    const MODEL = ProcessInstance::class;

    /**
     * @var array
     */
    protected static $map = [
        'id',
        'definitionId',
        'businessKey',
        'ended',
        'suspended',
        'tenantId',
        'caseInstanceId',
        'links',
        'variables'
    ];

    /**
     * {@inheritdoc}
     */
    public function getList(Parameters $parameters = null)
    {

    }

    /**
     * {@inheritdoc}
     */
    public function getCount(Parameters $parameters = null)
    {

    }

    /**
     * {@inheritdoc}
     */
    public function get($id, Parameters $parameters = null)
    {

    }
}
