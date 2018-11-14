<?php

namespace Ds\Component\Tenant\EventListener\Entity;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Ds\Component\Container\EventListener\ContainerListener;
use Ds\Component\Tenant\Model\Type\Tenantable;

/**
 * Class TenantableListener
 *
 * @package Ds\Component\Tenant
 */
final class TenantableListener extends ContainerListener
{
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

        $tenant = $this->container->get('ds_tenant.service.tenant')->getContext();
        $entity->setTenant($tenant);
    }
}
