<?php

namespace Ds\Component\Tenant\EventListener\Entity\Type;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Ds\Component\Tenant\Model\Type\Tenantable;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class TenantableListener
 *
 * @package Ds\Component\Tenant
 */
class TenantableListener
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
     * Assign the tenant uuid before persisting the entity, if none provided
     *
     * @param \Doctrine\ORM\Event\LifecycleEventArgs $args
     */
    public function prePersist(LifecycleEventArgs $args)
    {
        // @todo Fix circular logic error
        $tenantService = $this->container->get('ds_tenant.service.tenant');
        //

        $entity = $args->getEntity();

        if (!$entity instanceof Tenantable) {
            return;
        }

        if (null !== $entity->getTenant()) {
            return;
        }

        $tenant = $tenantService->getContext();
        $entity->setTenant($tenant);
    }
}
