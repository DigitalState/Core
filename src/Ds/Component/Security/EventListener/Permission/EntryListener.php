<?php

namespace Ds\Component\Security\EventListener\Permission;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Ds\Component\Security\Entity\Permission;
use Ds\Component\Security\Service\PermissionService;

/**
 * Class EntryListener
 */
class EntryListener
{
    /**
     * @var \Symfony\Component\HttpFoundation\RequestStack
     */
    protected $requestStack;

    /**
     * @var \Ds\Component\Security\Service\PermissionService
     */
    protected $permissionService;

    /**
     * Constructor
     *
     * @param \Symfony\Component\HttpFoundation\RequestStack $requestStack
     * @param \Ds\Component\Security\Service\PermissionService $permissionService
     */
    public function __construct(RequestStack $requestStack, PermissionService $permissionService)
    {
        $this->requestStack = $requestStack;
        $this->permissionService = $permissionService;
    }

    /**
     * Remove existing permission entries on put request
     *
     * @param \Symfony\Component\HttpKernel\Event\GetResponseEvent $event
     */
    public function kernelRequest(GetResponseEvent $event)
    {
        $request = $this->requestStack->getCurrentRequest();

        if (Request::METHOD_PUT !== $request->getMethod()) {
            return;
        }

        if (!$event->getRequest()->attributes->has('data')) {
            return;
        }

        $data = $event->getRequest()->attributes->get('data');

        if (!$data instanceof Permission) {
            return;
        }

        $permission = $data;

        foreach ($permission->getEntries() as $entry) {
            $entry->setPermission(null);
            $permission->getEntries()->removeElement($entry);
        }

        $this->permissionService->getManager()->persist($permission);
        $this->permissionService->getManager()->flush();
    }
}
