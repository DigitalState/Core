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
     * @var \Ds\Component\Api\Api\Factory
     */
    protected $factory;

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
        $this->factory = $factory;
    }

    /**
     * {@inheritdoc}
     */
    public function isMatch($variable, array &$matches = [])
    {
        if (!preg_match('/^ds\.(authentication)\.(user)\[([-a-zA-Z0-9]+)\]\.(.+)/', $variable, $matches)) {
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

        $api = $this->factory->create();
        $service = $matches[1];
        $entity = $matches[2];
        $id = $matches[3];
        $property = $matches[4];
        $model = $api->$service->$entity->get($id);
        $accessor = PropertyAccess::createPropertyAccessor();
        $value = $accessor->getValue($model, $property);

        return $value;
    }
}
