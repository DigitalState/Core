<?php

namespace Ds\Component\Api\Service\Cms;

use Ds\Component\Api\Model\Cms\File;
use Ds\Component\Api\Query\Cms\FileParameters as Parameters;
use Ds\Component\Api\Service\AbstractService;

/**
 * Class FileService
 *
 * @package Ds\Component\Api
 */
class FileService extends AbstractService
{
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
    protected static $map = [
        'id',
        'uuid'
    ];

    /**
     * Get file list
     *
     * @param \Ds\Component\Api\Query\Cms\FileParameters $parameters
     * @return array
     */
    public function getList(Parameters $parameters = null)
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
