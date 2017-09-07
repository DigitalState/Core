<?php

namespace Ds\Component\Api\Resolver;

use Ds\Component\Api\Api\Factory;
use Ds\Component\Resolver\Exception\UnresolvedException;
use Ds\Component\Resolver\Resolver\Resolver;
use Symfony\Component\PropertyAccess\PropertyAccess;

/**
 * Class ApiResolver
 *
 * @package Ds\Component\Api
 */
class ApiResolver implements Resolver
{
    /**
     * @var \Ds\Component\Api\Api\Api
     */
    protected $api;

    /**
     * Constructor
     *
     * @param \Ds\Component\Api\Api\Factory $factory
     */
    public function __construct(Factory $factory)
    {
        $this->api = $factory->create();
    }

    /**
     * {@inheritdoc}
     */
    public function isMatch($variable, array &$matches = [])
    {
        if (!preg_match('/^ds\.([a-zA-Z0-9]+)\.([a-zA-Z0-9]+)\[([-a-zA-Z0-9]+)\]\.(.+)/', $variable, $matches)) {
            return false;
        }

        $service = $matches[1];

        if (!property_exists($this->api, $service)) {
            return false;
        }

        $resource = $matches[2];

        if (!property_exists($this->api->$service, $resource)) {
            return false;
        }

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function resolve($variable)
    {
        $matches = [];

        if (!$this->isMatch($variable, $matches)) {
            throw new UnresolvedException('Variable pattern is not valid.');
        }

        $service = $matches[1];
        $resource = $matches[2];
        $id = $matches[3];
        $property = $matches[4];
        $model = $this->api->$service->$resource->get($id);
        $accessor = PropertyAccess::createPropertyAccessor();
        $value = $accessor->getValue($model, $property);

        return $value;
    }
}
