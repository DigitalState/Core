<?php

namespace Ds\Component\Api\Service;

use Ds\Component\Api\Service\Service as ServiceInterface;
use Ds\Component\Api\Model\Service;
use Ds\Component\Api\Query\ServiceParameters as Parameters;

/**
 * Class ServiceService
 *
 * @package Ds\Component\Api
 */
final class ServiceService implements ServiceInterface
{
    use Base;

    /**
     * @const string
     */
    const MODEL = Service::class;

    /**
     * @const string
     */
    const RESOURCE_LIST = '/services';
    const RESOURCE_OBJECT = '/services/{id}';

    /**
     * @var array
     */
    private static $map = [
        'id',
        'uuid'
    ];

    /**
     * Get service list
     *
     * @param \Ds\Component\Api\Query\ServiceParameters $parameters
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
