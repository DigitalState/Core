<?php

namespace Ds\Component\Api\Service;

use Ds\Component\Api\Model\Organization;
use Ds\Component\Api\Query\OrganizationParameters as Parameters;

/**
 * Class OrganizationService
 *
 * @package Ds\Component\Api
 */
final class OrganizationService implements Service
{
    use Base;

    /**
     * @const string
     */
    const MODEL = Organization::class;

    /**
     * @const string
     */
    const RESOURCE_LIST = '/organizations';
    const RESOURCE_OBJECT = '/organizations/{id}';

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
        'roles',
        'version',
        'tenant'
    ];

    /**
     * Get organization list
     *
     * @param \Ds\Component\Api\Query\OrganizationParameters $parameters
     * @return array
     */
    public function getList(Parameters $parameters = null): array
    {
        $objects = $this->execute('GET', static::RESOURCE_LIST);
        $list = [];

        foreach ($objects as $object) {
            $model = static::toModel($object);
            $list[] = $model;
        }

        return $list;
    }

    /**
     * Get organization
     *
     * @param string $id
     * @param \Ds\Component\Api\Query\OrganizationParameters $parameters
     * @return \Ds\Component\Api\Model\Organization
     */
    public function get($id, Parameters $parameters = null): Organization
    {
        $resource = str_replace('{id}', $id, static::RESOURCE_OBJECT);
        $object = $this->execute('GET', $resource);
        /** @var \Ds\Component\Api\Model\Organization $model */
        $model = static::toModel($object);

        return $model;
    }

    /**
     * Create organization
     *
     * @param \Ds\Component\Api\Model\Organization $organization
     * @param \Ds\Component\Api\Query\OrganizationParameters $parameters
     * @return \Ds\Component\Api\Model\Organization
     */
    public function create(Organization $organization, Parameters $parameters = null): Organization
    {
        $options = [];
        $options['json'] = (array) static::toObject($organization);

        if ($parameters) {
            $options['query'] = (array) $parameters->toObject(true);
        }

        $object = $this->execute('POST', static::RESOURCE_LIST, $options);
        /** @var \Ds\Component\Api\Model\Organization $organization */
        $organization = static::toModel($object);

        return $organization;
    }
}
