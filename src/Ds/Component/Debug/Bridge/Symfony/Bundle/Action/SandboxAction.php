<?php

namespace Ds\Component\Debug\Bridge\Symfony\Bundle\Action;

use Ds\Component\Formio\Query\FormParameters;
use Symfony\Component\DependencyInjection\ContainerInterface;

use ApiPlatform\Core\Annotation\ApiResource;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
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
