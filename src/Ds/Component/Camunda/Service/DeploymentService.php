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
class DeploymentService extends AbstractService
{
    /**
     * @const string
     */
    const MODEL = Deployment::class;

    /**
     * @const string
     */
    const RESOURCE_LIST = '/deployment';
    const RESOURCE_COUNT = '/deployment/count';
    const RESOURCE_OBJECT = '/deployment/{id}';
    const RESOURCE_CREATE = '/deployment/create';

    /**
     * @var array
     */
    protected static $map = [
        'id',
        'name',
        'source',
        'DeploymentTime',
    ];

    /**
     * Get list of deployments
     *
     * @param \Ds\Component\Camunda\Query\DeploymentParameters $parameters
     * @return array
     */
    public function getList(Parameters $parameters = null)
    {
        $objects = $this->execute('GET', static::RESOURCE_LIST);
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
                    'name' => 'deployment-name',
                    'contents' => $deployment->getName()
                ],
                [
                    'name' => 'deployment-source',
                    'contents' => $deployment->getSource()
                ]
            ]
        ];

        foreach ($deployment->getFiles() as $file) {
            $options['multipart'][] = [
                'name' => basename($file),
                'contents' => fopen($file, 'r'),
                'filename' => basename($file)
            ];
        }

        $object = $this->execute('POST', static::RESOURCE_CREATE, $options);
        $model = static::toModel($object);

        return $model;
    }
}
