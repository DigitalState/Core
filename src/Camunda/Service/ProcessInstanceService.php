<?php

namespace Ds\Component\Camunda\Service;

use Ds\Component\Api\Service\Service;
use Ds\Component\Camunda\Model\ProcessInstance;
use Ds\Component\Camunda\Query\ProcessInstanceParameters as Parameters;

/**
 * Class ProcessInstanceService
 *
 * @package Ds\Component\Camunda
 */
final class ProcessInstanceService implements Service
{
    use Base;

    /**
     * @const string
     */
    const MODEL = ProcessInstance::class;

    /**
     * @var array
     */
    private static $map = [
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
