<?php

namespace Ds\Component\Api\Service;

use Ds\Component\Api\Model\File;
use Ds\Component\Api\Query\FileParameters as Parameters;

/**
 * Class FileService
 *
 * @package Ds\Component\Api
 */
final class FileService implements Service
{
    use Base;

    /**
     * @const string
     */
    const MODEL = File::class;

    /**
     * @const string
     */
    const RESOURCE_LIST = '/files';
    const RESOURCE_OBJECT = '/files/{id}';

    /**
     * @var array
     */
    private static $map = [
        'id',
        'uuid'
    ];

    /**
     * Get file list
     *
     * @param \Ds\Component\Api\Query\FileParameters $parameters
     * @return array
     */
    public function getList(Parameters $parameters = null): array
    {
        $objects = $this->execute('GET', 'http://www.mocky.io/v2/592b798d100000b10e389778');
        $list = [];

        foreach ($objects as $object) {
            $model = static::toModel($object);
            $list[] = $model;
        }

        return $list;
    }
}
