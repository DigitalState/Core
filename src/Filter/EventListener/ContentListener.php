<?php

namespace Ds\Component\Filter\EventListener;

use Exception;
use function GuzzleHttp\json_decode;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/**
 * Class ContentListener
 *
 * @package Ds\Component\Filter
 */
final class ContentListener
{
    /**
     * Transfer get request content to api filters in order to allow large api filters
     *
     * @param \Symfony\Component\HttpKernel\Event\GetResponseEvent $event
     */
    public function kernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();
        $content = $request->getContent();

        if ('' === $content) {
            return;
        }

        try {
            $filters = json_decode($content, true);
        } catch (Exception $exception) {
            throw new BadRequestHttpException('Request body should be an object.', $exception);
        }

        if (!is_array($filters)) {
            throw new BadRequestHttpException('Request body should be an object.');
        }

        $current = $request->attributes->get('_api_filters', []);
        $query = $request->query->all();
        $filters = array_merge($current, $query, $filters);
        $request->attributes->set('_api_filters', $filters);
    }
}
