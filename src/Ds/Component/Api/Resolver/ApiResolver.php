<?php

namespace Ds\Component\Api\Resolver;

use Ds\Component\Api\Api\Factory;
use Ds\Component\Resolver\Exception\UnresolvedException;
use Ds\Component\Resolver\Resolver\Resolver;
use Exception;
use Symfony\Component\PropertyAccess\PropertyAccess;

/**
 * Class ApiResolver
 *
 * @package Ds\Component\Api
 */
class ApiResolver implements Resolver
{
    /**
     * \Ds\Component\Api\Api\Factory
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
        if (!preg_match('/^ds\.([_a-zA-Z0-9]+)\.([_a-zA-Z0-9]+)\[([-a-zA-Z0-9]+)\]\.(.+)/', $variable, $matches)) {
            return false;
        }

        if (!$this->api) {
            $this->api = $this->factory->create();
        }

        $service = $this->toProperty($matches[1]);

        if (!property_exists($this->api, $service)) {
            return false;
        }

        $resource = $this->toProperty($matches[2]);

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

        $service = $this->toProperty($matches[1]);
        $resource = $this->toProperty($matches[2]);
        $id = $matches[3];
        $property = $matches[4];

        if (!$this->api) {
            $this->api = $this->factory->create();
        }

        $model = $this->api->$service->$resource->get($id);
        $accessor = PropertyAccess::createPropertyAccessor();

        try {
            $value = $accessor->getValue($model, $property);
        } catch (Exception $exception) {
            throw new UnresolvedException('Variable pattern is not valid.', 0, $exception);
        }

        return $value;
    }

    /**
     * Transform variable pattern to property name
     *
     * @param string $variable
     * @return string
     */
    protected function toProperty($variable)
    {
        return lcfirst(str_replace('_', '', ucwords($variable, '_')));
    }
}
