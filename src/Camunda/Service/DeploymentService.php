<?php

namespace Ds\Component\Camunda\Service;

use Ds\Component\Camunda\Model\Deployment;
use Ds\Component\Camunda\Query\DeploymentParameters as Parameters;
use SimpleXMLElement;

/**
 * Class DeploymentService
 *
 * @package Ds\Component\Camunda
 */
final class DeploymentService implements Service
{
    use Base;

    /**
     * @const string
     */
    const MODEL = Deployment::class;

    /**
     * @const string
     */
    const RESOURCE_LIST = '/engine-rest/deployment';
    const RESOURCE_COUNT = '/engine-rest/deployment/count';
    const RESOURCE_OBJECT = '/engine-rest/deployment/{id}';
    const RESOURCE_CREATE = '/engine-rest/deployment/create';

    /**
     * @var array
     */
    private static $map = [
        'id',
        'name',
        'source',
        'deploymentTime',
        'tenantId'
    ];

    /**
     * Get list of deployments
     *
     * @param \Ds\Component\Camunda\Query\DeploymentParameters $parameters
     * @return array
     */
    public function getList(Parameters $parameters = null)
    {
        $options = [];

        if ($parameters) {
            $options['query'] = (array) $parameters->toObject(true);
        }

        $objects = $this->execute('GET', static::RESOURCE_LIST, $options);
        $list = [];

        foreach ($objects as $object) {
            $model = static::toModel($object);
            $list[] = $model;
        }

        return $list;
    }

    /**
     * Get count of deployments
     *
     * @param \Ds\Component\Camunda\Query\DeploymentParameters $parameters
     * @return integer
     */
    public function getCount(Parameters $parameters = null)
    {
        $result = $this->execute('GET', static::RESOURCE_COUNT);

        return $result->count;
    }

    /**
     * Get deployment
     *
     * @param string $id
     * @param \Ds\Component\Camunda\Query\DeploymentParameters $parameters
     * @return \Ds\Component\Camunda\Model\Deployment
     */
    public function get($id, Parameters $parameters = null)
    {
        $resource = str_replace('{id}', $id, static::RESOURCE_OBJECT);
        $object = $this->execute('GET', $resource);
        $model = static::toModel($object);

        return $model;
    }

    /**
     * Create deployment
     *
     * @param \Ds\Component\Camunda\Model\Deployment $deployment
     * @return \Ds\Component\Camunda\Model\Deployment
     */
    public function create(Deployment $deployment)
    {
        $options = [
            'multipart' => [
                [
                    'Content-Disposition' => 'form-data',
                    'name' => 'deployment-name',
                    'contents' => $deployment->getName()
                ],
                [
                    'Content-Disposition' => 'form-data',
                    'name' => 'deployment-source',
                    'contents' => $deployment->getSource()
                ],
                [
                    'Content-Disposition' => 'form-data',
                    'name' => 'tenant-id',
                    'contents' => $deployment->getTenantId()
                ]
            ]
        ];

        foreach ($deployment->getFiles() as $file) {
            $options['multipart'][] = [
                'Content-Disposition' => 'form-data',
                'name' => basename($file),
                'filename' => basename($file),
                'contents' => fopen($file, 'r')
            ];
        }

        $object = $this->execute('POST', static::RESOURCE_CREATE, $options);
        $model = static::toModel($object);

        return $model;
    }

    /**
     * Delete deployment
     *
     * @param string $id
     * @param \Ds\Component\Camunda\Query\DeploymentParameters $parameters
     */
    public function delete($id, Parameters $parameters = null)
    {
        $resource = str_replace('{id}', $id, static::RESOURCE_OBJECT);
        $options = [];

        if ($parameters) {
            $options['query'] = (array) $parameters->toObject(true);
        }

        $this->execute('DELETE', $resource, $options);
    }
}
