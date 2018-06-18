<?php

namespace Ds\Component\Tenant\Service;

use Ds\Component\Config\Service\ParameterService;
use Ds\Component\Security\Model\User;
use Ds\Component\Tenant\Collection\LoaderCollection;
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
     * @var \Ds\Component\Config\Service\ParameterService
     */
    protected $parameterService;

    /**
     * @var \Symfony\Component\HttpFoundation\RequestStack
     */
    protected $requestStack;

    /**
     * @var \Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface
     */
    protected $tokenStorage;

    /**
     * @var \Ds\Component\Tenant\Collection\LoaderCollection
     */
    protected $loaderCollection;

    /**
     * Constructor
     *
     * @param \Ds\Component\Config\Service\ParameterService $parameterService
     * @param \Symfony\Component\HttpFoundation\RequestStack $requestStack
     * @param \Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface $tokenStorage
     * @param \Ds\Component\Tenant\Collection\LoaderCollection $loaderCollection
     */
    public function __construct(ParameterService $parameterService, RequestStack $requestStack, TokenStorageInterface $tokenStorage, LoaderCollection $loaderCollection)
    {
        $this->parameterService = $parameterService;
        $this->requestStack = $requestStack;
        $this->tokenStorage = $tokenStorage;
        $this->loaderCollection = $loaderCollection;
    }

    /**
     * Get the contextual tenant
     *
     * @return string
     */
    public function getContext()
    {
        $tenant = $this->parameterService->get('ds_tenant.tenant.default');
        $request = $this->requestStack->getCurrentRequest();

        if ($request->request->has('tenant')) {
            $tenant = $request->request->get('tenant');
        } else if ($request->query->has('tenant')) {
            $tenant = $request->query->get('tenant');
        }

        $token = $this->tokenStorage->getToken();

        if ($token) {
            $user = $token->getUser();

            if ($user instanceof User) {
                $tenant = $user->getTenant();
            }
        }

        return $tenant;
    }

    /**
     * Load a new tenant
     *
     * @param array $data
     * @return \Ds\Component\Tenant\Service\TenantService
     * @throws \InvalidArgumentException
     */
    public function load(array $data)
    {
        foreach ($this->loaderCollection as $loader) {
            $loader->load($data);
        }

        return $this;
    }
}
