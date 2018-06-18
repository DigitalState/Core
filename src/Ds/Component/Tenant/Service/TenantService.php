<?php

namespace Ds\Component\Tenant\Service;

use Doctrine\ORM\EntityManager;
use Ds\Component\Config\Service\ParameterService;
use Ds\Component\Security\Model\User;
use Ds\Component\Tenant\Collection\LoaderCollection;
use Exception;
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
     * @var \Doctrine\ORM\EntityManager
     */
    protected $entityManager;

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
     * @param \Doctrine\ORM\EntityManager $entityManager
     * @param \Ds\Component\Config\Service\ParameterService $parameterService
     * @param \Symfony\Component\HttpFoundation\RequestStack $requestStack
     * @param \Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface $tokenStorage
     * @param \Ds\Component\Tenant\Collection\LoaderCollection $loaderCollection
     */
    public function __construct(EntityManager $entityManager, ParameterService $parameterService, RequestStack $requestStack, TokenStorageInterface $tokenStorage, LoaderCollection $loaderCollection)
    {
        $this->entityManager = $entityManager;
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
     * @throws \Exception
     * @example
     * <code>
     * [
     *     'user' => [
     *         'system' => [
     *             'uuid' => 'd9e66aeb-d853-41bc-ad9e-ae6fb18fb067',
     *             'password' => 'password'
     *         ],
     *         'admin' => [
     *             'uuid' => '28de3e41-87c1-47c9-813d-07a87278fc00',
     *             'password' => 'password'
     *         ]
     *     ],
     *     'identity' => [
     *         'system' => [
     *             'uuid' => '782637a1-7366-4805-a853-869f65fa3965'
     *         ],
     *         'admin' => [
     *             'uuid' => '782637a1-7366-4805-a853-869f65fa3965'
     *         ]
     *     ],
     *     'business_unit' => [
     *         'administration' => [
     *             'uuid' => '5675406b-f2ed-453a-b3ef-5be4596e7da6'
     *         ]
     *     ],
     *     'tenant' => [
     *         'uuid' => '10e287ef-fcd0-45e1-b178-b44be9f2363a'
     *     ],
     *     'config' => [
     *         'app.spa.admin' => [
     *             'value' => 'admin.ds'
     *         ],
     *         'app.spa.portal' => [
     *             'value' => 'portal.ds'
     *         ]
     *     ]
     * ]
     * </code>
     */
    public function load(array $data)
    {
        $connection = $this->entityManager->getConnection();
        $connection->beginTransaction();

        try {
            foreach ($this->loaderCollection as $loader) {
                $loader->load($data);
            }

            $connection->commit();
        } catch (Exception $exception) {
            $connection->rollBack();
            throw $exception;
        }

        return $this;
    }
}
