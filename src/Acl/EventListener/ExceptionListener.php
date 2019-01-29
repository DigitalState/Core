<?php

namespace Ds\Component\Acl\EventListener;

use Ds\Component\Acl\Exception\NoPermissionsException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;

/**
 * Class ExceptionListener
 *
 * @package Ds\Component\Acl
 */
final class ExceptionListener
{
    /**
     * Convert NoPermissionsException into empty collections
     *
     * @param \Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent $event
     * @throws \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException
     */
    public function kernelException(GetResponseForExceptionEvent $event)
    {
        $exception = $event->getException();

        if (!$exception instanceof NoPermissionsException) {
            return;
        }

        // In the event a user requests a list of entities and has no permissions,
        // an empty list is returned.
        $response = new JsonResponse([]);
        $event->setResponse($response);
    }
}
