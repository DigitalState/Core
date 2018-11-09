<?php

namespace Ds\Component\Exception\EventListener;

use ApiPlatform\Core\Bridge\Symfony\Validator\Exception\ValidationException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Class ExceptionListener
 *
 * @package Ds\Component\Exception
 */
final class ExceptionListener
{
    /**
     * @var string
     */
    private $environment;

    /**
     * Constructor
     *
     * @param string $environment
     */
    public function __construct(string $environment)
    {
        $this->environment = $environment;
    }

    /**
     * Format uncaught exceptions into the proper format based on request
     *
     * @param \Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent $event
     */
    public function kernelException(GetResponseForExceptionEvent $event)
    {
        $exception = $event->getException();

        if ($exception instanceof HttpException || $exception instanceof ValidationException) {
            return;
        }

        $data = [
            'type' => 'https://tools.ietf.org/html/rfc2616#section-10',
            'title' =>'An error occurred',
            'detail' => ''
        ];

        if ('dev' === $this->environment) {
            $data['detail'] = $exception->getMessage();
            $data['trace'] = $exception->getTrace();
        }

        $request = $event->getRequest();
        $contentTypes = $request->getAcceptableContentTypes();
        $accept = array_shift($contentTypes);

        switch ($accept) {
            case 'application/json':
                $response = new JsonResponse($data, Response::HTTP_INTERNAL_SERVER_ERROR);
                $event->setResponse($response);
                break;
        }
    }
}
