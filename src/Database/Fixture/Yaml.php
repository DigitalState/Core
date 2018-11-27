<?php

namespace Ds\Component\Database\Fixture;

use Ds\Component\Container\Attribute;
use Ds\Component\Database\Util\Objects;
use LogicException;

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
        $fixtures = array_key_exists('FIXTURES', $_ENV) ? $_ENV['FIXTURES'] : 'dev';
        $files = glob(str_replace('{fixtures}', $fixtures, $path));

        if (!$files) {
            throw new LogicException('Fixtures path "'.$path.'" yields no files.');
        }

        $objects = [];

        foreach ($files as $file) {
            foreach (Objects::parseFile($file) as $object) {
                $objects[] = $object;
            }
        }

        return $objects;
    }
}
