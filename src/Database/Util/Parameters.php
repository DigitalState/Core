<?php

namespace Ds\Component\Database\Util;

use Symfony\Component\ExpressionLanguage\ExpressionLanguage;
use Symfony\Component\Yaml\Yaml;

/**
 * Class Parameters
 *
 * @package Ds\Component\Database
 */
final class Parameters
{
    /**
     * Parse parameters string to array
     *
     * @param string $string
     * @return array
     */
    public static function parse(string $string): array
    {
        $array = (array) Yaml::parse($string, Yaml::PARSE_OBJECT_FOR_MAP);

        return $array;
    }

    /**
     * Parse parameters file to array
     *
     * @param string $file
     * @return array
     */
    public static function parseFile(string $file): array
    {
        $string = file_get_contents($file);

        return static::parse($string);
    }

    /**
     * Replace parameter placeholders with data
     *
     * @param string $string
     * @param array $data
     * @return string
     */
    public static function replace(string $string, array $data = []): string
    {
        $expressionLanguage = new ExpressionLanguage;
        preg_match_all('/\%([a-z0-9_\[\]\.]+)\%/i', $string, $matches);
        $placeholders = array_unique($matches[1]);
        $translations = [];

        foreach ($placeholders as $placeholder) {
            $translations['%'.$placeholder.'%'] = $expressionLanguage->evaluate($placeholder, $data);
        }

        $string = strtr($string, $translations);

        return $string;
    }
}
