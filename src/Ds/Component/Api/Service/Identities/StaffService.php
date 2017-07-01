<?php

namespace Ds\Component\Api\Service\Identities;

use Ds\Component\Api\Model\Identities\Staff;
use Ds\Component\Api\Query\Identities\StaffParameters as Parameters;
use Ds\Component\Api\Service\AbstractService;

/**
 * Class StaffService
 */
class StaffService extends AbstractService
{
    /**
     * @const string
     */
    const MODEL = Staff::class;

    /**
     * @const string
     */
    const RESOURCE_LIST = '/staff';
    const RESOURCE_OBJECT = '/staff/{id}';

    /**
     * @var array
     */
    protected static $map = [
        'id',
        'uuid'
    ];

    /**
     * Get individual list
     *
     * @param \Ds\Component\Api\Query\Identities\StaffParameters $parameters
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
