<?php

namespace Ds\Component\Database\Fixture;

use DomainException;
use Ds\Component\Container\Attribute;
use LogicException;
use Symfony\Component\Yaml\Yaml as YamlParser;

/**
 * Trait Yaml
 *
 * This trait provides the ability to load fixtures from YAML configuration files.
 *
 * @package Ds\Component\Database
 * @example A YAML resource configuration file
 * <code>
 * objects:
 *   - uuid: 1ea40809-0520-482f-a4d6-7973228b225a
 *     title: Item 1
 *   - uuid: 7f51d089-945a-4f80-9c05-4e2fe924d214
 *     title: Item 2
 *
 * prototype:
 *   uuid: ~
 *   title: Default title
 * </code>
 */
trait Yaml
{
    use Attribute\Container;

    /**
     * Parse resource files to objects
     *
     * @param string $path
     * @return array
     * @throws \DomainException
     * @throws \LogicException
     */
    protected function parse($path): array
    {
        $env = $this->container->get('kernel')->getEnvironment();
        $files = glob(str_replace('{env}', $env, $path));

        if (!$files) {
            throw new LogicException('Fixture path "'.$path.'" yields nothing.');
        }

        $objects = [];

        foreach ($files as $file) {
            $extension = pathinfo($file, PATHINFO_EXTENSION);

            switch ($extension) {
                case 'yaml':
                case 'yml':
                    $config = YamlParser::parse(file_get_contents($file), YamlParser::PARSE_OBJECT_FOR_MAP);

                    if (!property_exists($config,'objects')) {
                        throw new LogicException('Config property "objects" does not exist.');
                    }

                    if (!is_array($config->objects)) {
                        throw new LogicException('Config property "objects" is not an array.');
                    }

                    $prototype = [];

                    if (property_exists($config,'prototype')) {
                        if (!is_object($config->prototype)) {
                            throw new LogicException('Config property "prototype" is not an object.');
                        }

                        $prototype = $config->prototype;
                    }

                    foreach ($config->objects as $object) {
                        $objects[] = (object) array_merge((array) $prototype, (array) $object);
                    }

                    break;

                default:
                    throw new DomainException('Resource file extension is not supported.');
            }
        }

        return $objects;
    }
}
