<?php

namespace Ds\Component\Camunda\Fixture\Camunda;

use Doctrine\Common\Persistence\ObjectManager;
use Ds\Component\Camunda\Model\Deployment;
use Ds\Component\Camunda\Query\DeploymentParameters;
use Ds\Component\Database\Fixture\ResourceFixture;

/**
 * Class DeploymentFixture
 *
 * @package Ds\Component\Camunda
 */
abstract class DeploymentFixture extends ResourceFixture
{
    /**
     * @const string
     */
    const DEPLOYMENT_SOURCE = 'ds.{app}.fixtures.{env}';

    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        // @todo remove dependency on ds_api, add camunda api services
        $app = $this->container->getParameter('app');
        $env = $this->container->get('kernel')->getEnvironment();

        // @todo create mock server instead of skipping fixture
        if ('test' === $env) {
            return;
        }

        $source = str_replace(['{app}', '{env}'], [$app, $env], static::DEPLOYMENT_SOURCE);
        $api = $this->container->get('ds_api.api')->get('camunda.deployment');
        $parameters = new DeploymentParameters;
        $parameters->setSource($source);
        $deployments = $api->getList($parameters);

        foreach ($deployments as $deployment) {
            $parameters = new DeploymentParameters;
            $parameters->setCascade(true);
            $api->delete($deployment->getId(), $parameters);
        }

        $deployments = $this->parse($this->getResource());

        foreach ($deployments as $deployment) {
            $entry = new Deployment;
            $entry
                ->setName($deployment['name'])
                ->setSource($source);
            $files = [];

            foreach ($deployment['files'] as $file) {
                $files[] = dirname(str_replace('{env}', $env, $this->getResource())).'/'.$file;
            }

            $entry->setFiles($files);
            $api->create($entry);
        }
    }

    /**
     * Get resource
     *
     * @return string
     */
    abstract protected function getResource();
}
