<?php

namespace Ds\Component\Parameter\Twig\Extension;

use Ds\Component\Parameter\Service\ParameterService;
use Twig_Extension;
use Twig_SimpleFunction;

/**
 * Class ParameterExtension
 *
 * @package Ds\Component\Parameter
 */
final class ParameterExtension extends Twig_Extension
{
    /**
     * @var \Ds\Component\Parameter\Service\ParameterService
     */
    protected $parameterService;

    /**
     * Constructor
     *
     * @param \Ds\Component\Parameter\Service\ParameterService $parameterService
     */
    public function __construct(ParameterService $parameterService)
    {
        $this->parameterService = $parameterService;
    }

    /**
     * Get functions
     *
     * @return array
     */
    public function getFunctions()
    {
        return [
            new Twig_SimpleFunction('ds_parameter', [$this, 'get'])
        ];
    }

    /**
     * Get parameter value
     *
     * @param string $name
     * @return mixed
     */
    public function get($name)
    {
        return $this->parameterService->get($name);
    }
}
