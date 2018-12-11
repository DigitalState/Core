<?php

namespace Ds\Component\Camunda\Fixture\Camunda;

use Doctrine\Common\Persistence\ObjectManager;
use Ds\Component\Camunda\Model\Deployment as DeploymentModel;
use Ds\Component\Camunda\Query\DeploymentParameters;
use Ds\Component\Database\Fixture\Yaml;

/**
 * Trait Access
 *
 * @package Ds\Component\Camunda
 */
trait Deployment
{
    use Yaml;

    /**
     * @var string
     */
    private $app;

    /**
     * @var string
     */
    private $namespace;

    /**
     * @var string
     */
    private $path;

    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $env = $this->container->get('kernel')->getEnvironment();

        // @todo create mock server instead of skipping fixture
        if ('test' === $env) {
            return;
        }

        $fixtures = array_key_exists('FIXTURES', $_ENV) ? $_ENV['FIXTURES'] : 'dev';
        $source = $this->namespace.'.'.$this->app.'.fixtures.'.$fixtures;
        $api = $this->container->get('ds_api.api')->get('camunda.deployment');
        $parameters = new DeploymentParameters;
        $parameters->setSource($source);
        $deployments = $api->getList($parameters);

        foreach ($deployments as $deployment) {
            $parameters = new DeploymentParameters;
            $parameters->setCascade(true);
            $api->delete($deployment->getId(), $parameters);
        }

        $objects = $this->parse($this->getResource());

        foreach ($objects as $object) {
            $deployment = new DeploymentModel;
            $deployment
                ->setName($object->name)
                ->setSource($source)
                ->setTenantId($object->tenant_id);
            $files = [];

            foreach ($object->files as $file) {
                $files[] = dirname(str_replace('{env}', $env, $this->getResource())).'/'.$file;
            }

            $deployment->setFiles($files);
            $api->create($deployment);
        }
    }
}
