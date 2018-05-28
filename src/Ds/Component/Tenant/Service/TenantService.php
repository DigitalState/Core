<?php

namespace Ds\Component\Tenant\Service;

use Ds\Component\Tenant\Collection\InitializerCollection;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * Class TenantService
 *
 * @package Ds\Component\Tenant\Service
 */
class TenantService
{
    /**
     * @var \Symfony\Component\HttpFoundation\RequestStack
     */
    protected $requestStack;

    /**
     * @var \Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface
     */
    protected $tokenStorage;

    /**
     * @var \Ds\Component\Tenant\Collection\InitializerCollection
     */
    protected $initializerCollection;

    /**
     * Constructor
     *
     * @param \Symfony\Component\HttpFoundation\RequestStack $requestStack
     * @param \Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface $tokenStorage
     * @param \Ds\Component\Tenant\Collection\InitializerCollection $initializerCollection
     */
    public function __construct(RequestStack $requestStack, TokenStorageInterface $tokenStorage, InitializerCollection $initializerCollection)
    {
        $this->requestStack = $requestStack;
        $this->tokenStorage = $tokenStorage;
        $this->initializerCollection = $initializerCollection;
    }

    /**
     * Get the contextual tenant
     *
     * @return string
     */
    public function getContext()
    {
        $tenant = null;
        $request = $this->requestStack->getCurrentRequest();

        if ($request->request->has('tenant')) {
            $tenant = $request->request->get('tenant');
        } else if ($request->query->has('tenant')) {
            $tenant = $request->query->get('tenant');
        }

        $token = $this->tokenStorage->getToken();

        if ($token) {
            $user = $token->getUser();
            $tenant = $user->getTenant();
        }

        return $tenant;
    }

    /**
     * Initialize tenant
     *
     * @param array $data
     * @return \Ds\Component\Tenant\Service\TenantService
     * @throws \InvalidArgumentException
     */
    public function initialize(array $data)
    {
        foreach ($this->initializerCollection as $initializer) {
            $initializer->initialize($data);
        }

        return $this;
    }
}
