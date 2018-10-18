<?php

namespace Ds\Component\Debug\Controller;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

use Symfony\Component\Routing\Annotation\Route;

/**
 * Class SandboxController
 *
 * @package Ds\Component\Debug
 */
final class SandboxController
{
    /**
     * @var \Symfony\Component\DependencyInjection\ContainerInterface
     */
    protected $container;

    /**
     * Constructor
     *
     * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * Action
     *
     * @Route(path="/sandbox", methods={"GET"})
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function get(): JsonResponse
    {
        return new JsonResponse;
    }
}
