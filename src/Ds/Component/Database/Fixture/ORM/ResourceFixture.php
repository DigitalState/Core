<?php

namespace Ds\Component\Database\Fixture\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Ds\Component\Container\Attribute;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\Yaml\Yaml;

/**
 * Class ResourceFixture
 */
abstract class ResourceFixture extends AbstractFixture implements ContainerAwareInterface
{
    use Attribute\Container;

    /**
     * Parse resource file(s)
     *
     * @param string $resource
     * @return array
     */
    protected function parse($resource)
    {
        $env = $this->container->get('kernel')->getEnvironment();
        $resource = str_replace('{env}', $env, $resource);
        $items = [];

        foreach (glob($resource) as $file) {
            $yml = file_get_contents($file);
            $data = Yaml::parse($yml);

            foreach ($data['items'] as $item) {
                $item += $data['prototype'];
                $items[] = $item;
            }
        }

        return $items;
    }
}
