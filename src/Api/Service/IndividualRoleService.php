<?php

namespace Ds\Component\Api\Service;

use Ds\Component\Api\Model\IndividualRole;
use Ds\Component\Api\Query\IndividualRoleParameters as Parameters;

/**
 * Class IndividualRoleService
 *
 * @package Ds\Component\Api
 */
final class IndividualRoleService implements Service
{
    use Base;

    /**
     * @const string
     */
    const MODEL = IndividualRole::class;

    /**
     * @const string
     */
    const RESOURCE_LIST = '/individual_roles';

    /**
     * @var array
     */
    private static $map = [
        'id',
        'uuid',
        'createdAt',
        'updatedAt',
        'owner',
        'ownerUuid',
        'individual',
        'role',
        'businessUnits',
        'version',
        'tenant'
    ];

    /**
     * Get individual role list
     *
     * @param \Ds\Component\Api\Query\IndividualRoleParameters $parameters
     * @return array
     */
    public function getList(Parameters $parameters = null): array
    {
        $options = [];

        if ($parameters) {
            $options['query'] = (array) $parameters->toObject(true);

            if (array_key_exists('individualUuid', $options['query'])) {
                $options['query']['individual.uuid'] = $options['query']['individualUuid'];
                unset($options['query']['individualUuid']);
            }
        }

        $objects = $this->execute('GET', static::RESOURCE_LIST, $options);
        $list = [];

        foreach ($objects as $object) {
            $model = static::toModel($object);
            $list[] = $model;
        }

        return $list;
    }
}
