<?php

namespace Ds\Component\Bpm\Resolver\Context;

use DomainException;
use Ds\Component\Api\Api\Api;
use Ds\Component\Camunda\Query\VariableParameters;
use Ds\Component\Resolver\Exception\UnresolvedException;
use Exception;
use Symfony\Component\PropertyAccess\PropertyAccess;

/**
 * Class BpmResolver
 */
class BpmResolver
{
    /**
     * @const string
     */
    const PATTERN = '/^ds\[bpm\]\.(.+)/';
    const PATTERN_TASK = '/^(task\.variable)\.([-_a-zA-Z0-9]+)(\.(.+))?/';

    /**
     * @const string
     */
    const CONTEXT_TASK = 'task';

    /**
     * @var \Ds\Component\Api\Api\Api
     */
    protected $api;

    /**
     * @var array
     */
    protected $contexts;

    /**
     * Constructor
     *
     * @param \Ds\Component\Api\Api\Api $api
     */
    public function __construct(Api $api)
    {
        $this->api = $api;
        $this->contexts = [];
    }

    /**
     * {@inheritdoc}
     */
    public function isMatch($variable, array &$matches = [])
    {
        if (!preg_match(static::PATTERN, $variable, $matches)) {
            return false;
        }

        $variable = $matches[1];

        foreach (array_keys($this->contexts) as $context) {
            switch ($context) {
                case static::CONTEXT_TASK:
                    if (preg_match(static::PATTERN_TASK, $variable, $matches)) {
                        return true;
                    }

                    break;
            }
        }

        return false;
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

        $value = null;
        $resource = $matches[1];

        switch ($resource) {
            case 'task.variable':
                $task = $this->contexts[static::CONTEXT_TASK];
                $variable = $matches[2];
                $property = array_key_exists(4, $matches) ? $matches[4] : null;
                $parameters = new VariableParameters;
                $parameters->setDeserializeValues(true);
                $variables = $this->api->get('camunda.task.variable')->getList($task, $parameters);

                if (!array_key_exists($variable, $variables)) {
                    throw new UnresolvedException('Variable pattern did not resolve to data.');
                }

                $value = $variables[$variable]->getValue();

                if (null !== $property) {
                    $accessor = PropertyAccess::createPropertyAccessor();

                    try {
                        $value = $accessor->getValue($value, $property);
                    } catch (Exception $exception) {
                        throw new UnresolvedException('Variable pattern is not valid.', 0, $exception);
                    }
                }

                break;
        }

        return $value;
    }

    /**
     * Set context
     *
     * @param string $context
     * @param mixed $value
     * @return \Ds\Component\Bpm\Resolver\Context\BpmResolver
     * @throws \DomainException
     */
    public function setContext($context, $value)
    {
        if (!in_array($context, [static::CONTEXT_TASK], true)) {
            throw new DomainException('Context does not exist.');
        }

        $this->contexts[$context] = $value;

        return $this;
    }
}
