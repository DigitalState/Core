<?php

namespace Ds\Component\Migration\Fixture\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Ds\Component\Container\Attribute;
use Symfony\Component\Yaml\Yaml;

/**
 * Class ResourceFixture
 */
abstract class ResourceFixture extends AbstractFixture implements ContainerAwareInterface
{
    use Attribute\Container;

    /**
     * Parse resource file
     *
     * @param string $resource
     * @return array
     */
    protected function parse($resource)
    {
        $server = $this->container->getParameter('server');
        $resource = str_replace('{server}', $server, $resource);
        $key = pathinfo($resource)['filename'];
        $yml = file_get_contents($resource);
        $data = Yaml::parse($yml);
        $items = [];

        foreach ($data[$key] as $item) {
            $item += $data['prototype'];
            $items[] = $item;
        }

        return $items;
    }
}
