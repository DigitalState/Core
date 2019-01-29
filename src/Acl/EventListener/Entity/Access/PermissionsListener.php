<?php

namespace Ds\Component\Acl\EventListener\Entity\Access;

use Ds\Component\Acl\Entity\Access;
use Ds\Component\Acl\Service\AccessService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

/**
 * Class PermissionsListener
 *
 * @package Ds\Component\Acl
 */
final class PermissionsListener
{
    /**
     * @var \Ds\Component\Acl\Service\AccessService
     */
    private $accessService;

    /**
     * Constructor
     *
     * @param \Ds\Component\Acl\Service\AccessService $accessService
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
