<?php

namespace Ds\Component\Security\EventListener\Access;

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
     * @var \Ds\Component\Security\Service\AccessService
     */
    protected $accessService;

    /**
     * Constructor
     *
     * @param \Ds\Component\Security\Service\AccessService $accessService
     */
    public function __construct(AccessService $accessService)
    {
        $this->accessService = $accessService;
    }

    /**
     * Remove the existing permissions on an update request
     *
     * @param \Symfony\Component\HttpKernel\Event\GetResponseEvent $event
     */
    public function kernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();

        if (!$request->isMethod(Request::METHOD_PUT)) {
            return;
        }

        if (!$request->attributes->has('data')) {
            return;
        }

        $data = $request->attributes->get('data');

        if (!$data instanceof Access) {
            return;
        }

        $access = $data;
        $manager = $this->accessService->getManager();

        foreach ($access->getPermissions() as $permission) {
            $manager->remove($permission);
        }

        $manager->flush();
    }
}
