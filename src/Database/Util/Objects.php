<?php

namespace Ds\Component\Database\Util;

use LogicException;
use Symfony\Component\Yaml\Yaml;

/**
 * Class Objects
 *
 * @package Ds\Component\Database
 */
final class Objects
{
    /**
     * Parse objects-formatted string into objects
     *
     * @param string $string
     * @param array $data
     * @return array
     * @throws \LogicException
     */
    public static function parse(string $string, array $data = []): array
    {
        if ($data) {
            $string = Parameters::replace($string, $data);
        }

        $data = Yaml::parse($string, Yaml::PARSE_OBJECT_FOR_MAP);

        if (!property_exists($data,'objects')) {
            throw new LogicException('Property "objects" does not exist.');
        }

        if (!is_array($data->objects)) {
            throw new LogicException('Property "objects" is not an array.');
        }

        $prototype = [];

        if (property_exists($data,'prototype')) {
            if (!is_object($data->prototype)) {
                throw new LogicException('Property "prototype" is not an object.');
            }

            $prototype = $data->prototype;
        }

        $objects = [];

        foreach ($data->objects as $object) {
            $objects[] = (object) array_merge((array) $prototype, (array) $object);
        }

        return $objects;
    }

    /**
     * Parse objects file into objects
     *
     * @param string $file
     * @param array $data
     * @return array
     */
    public static function parseFile(string $file, array $data = []): array
    {
        $string = file_get_contents($file);

        return static::parse($string, $data);
    }
}
