<?php

namespace Ds\Component\Camunda\Fixture\Camunda;

use Doctrine\Common\Persistence\ObjectManager;
use Ds\Component\Camunda\Model\Deployment;
use Ds\Component\Database\Fixture\ResourceFixture;

/**
 * Class DeploymentFixture
 *
 * @package Ds\Component\Camunda
 */
abstract class DeploymentFixture extends ResourceFixture
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        // @todo remove dependency on ds_api, add camunda api services
        $api = $this->container->get('ds_api.api')->get('camunda.deployment');
        $deployments = $this->parse($this->getResource());

        foreach ($deployments as $deployment) {
            $entry = new Deployment;
            $entry
                ->setName($deployment['name'])
                ->setSource($deployment['source']);
            $files = [];

            foreach ($deployment['files'] as $file) {
                $files[] = dirname($this->getResource()).'/'.$file;
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
