<?php

namespace Ds\Component\Migration\Fixture\ORM;

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
        $server = $this->container->getParameter('server');
        $resource = str_replace('{server}', $server, $resource);
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
