<?php

namespace Ds\Component\Security\EventListener\Access;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Ds\Component\Security\Entity\Access;
use Ds\Component\Security\Service\AccessService;

/**
 * Class PermissionsListener
 */
class PermissionsListener
{
    /**
     * @var \Symfony\Component\HttpFoundation\RequestStack
     */
    protected $requestStack;

    /**
     * @var \Ds\Component\Security\Service\AccessService
     */
    protected $accessService;

    /**
     * Constructor
     *
     * @param \Symfony\Component\HttpFoundation\RequestStack $requestStack
     * @param \Ds\Component\Security\Service\AccessService $accessService
     */
    public function __construct(RequestStack $requestStack, AccessService $accessService)
    {
        $this->requestStack = $requestStack;
        $this->accessService = $accessService;
    }

    /**
     * Remove existing permissions on put request
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

        if (!$data instanceof Access) {
            return;
        }

        $access = $data;

        foreach ($access->getPermissions() as $permission) {
            $this->accessService->getManager()->remove($permission);
        }

        $this->accessService->getManager()->flush();
    }
}
