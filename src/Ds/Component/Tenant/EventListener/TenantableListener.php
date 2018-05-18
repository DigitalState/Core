<?php

namespace Ds\Component\Tenant\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Ds\Component\Tenant\Model\Type\Tenantable;
use Ds\Component\Tenant\Service\TenantService;

/**
 * Class TenantableListener
 *
 * @package Ds\Component\Tenant
 */
class TenantableListener
{
    /**
     * @var \Ds\Component\Tenant\Service\TenantService
     */
    protected $tenantService;

    /**
     * Constructor
     *
     * @param \Ds\Component\Tenant\Service\TenantService $tenantService
     */
    public function __construct(TenantService $tenantService)
    {
        $this->tenantService = $tenantService;
    }

    /**
     * Assign the tenant uuid before persisting the entity, if none provided
     *
     * @param \Doctrine\ORM\Event\LifecycleEventArgs $args
     */
    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if (!$entity instanceof Tenantable) {
            return;
        }

        if (null !== $entity->getTenant()) {
            return;
        }

        $tenant = $this->tenantService->getTenant();
        $entity->setTenant($tenant);
    }
}
