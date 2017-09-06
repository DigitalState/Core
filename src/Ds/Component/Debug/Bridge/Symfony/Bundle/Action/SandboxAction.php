<?php

namespace Ds\Component\Debug\Bridge\Symfony\Bundle\Action;

use Symfony\Component\DependencyInjection\ContainerInterface;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class SandboxAction
 *
 * @package Ds\Component\Debug
 */
class SandboxAction
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
     * @Method("GET")
     * @Route(path="/sandbox")
     */
    public function get()
    {
        exit;
    }
}
