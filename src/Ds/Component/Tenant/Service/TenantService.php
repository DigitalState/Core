<?php

namespace Ds\Component\Tenant\Service;

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
     * Constructor
     *
     * @param \Symfony\Component\HttpFoundation\RequestStack $requestStack
     * @param \Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface $tokenStorage
     */
    public function __construct(RequestStack $requestStack, TokenStorageInterface $tokenStorage)
    {
        $this->requestStack = $requestStack;
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * Get the contextual tenant
     *
     * @return string
     */
    public function getTenant()
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
}
