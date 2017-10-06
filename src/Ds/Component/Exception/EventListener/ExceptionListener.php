<?php

namespace Ds\Component\Exception\EventListener;

use ApiPlatform\Core\Bridge\Symfony\Validator\Exception\ValidationException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Class ExceptionListener
 *
 * @package Ds\Component\Exception
 */
class ExceptionListener
{
    /**
     * @var string
     */
    protected $environment;

    /**
     * Constructor
     *
     * @param string $environment
     */
    public function __construct($environment)
    {
        $this->environment = $environment;
    }

    /**
     * Display json when an exception is thrown and uncaught
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

        $response = new JsonResponse($data);
        $event->setResponse($response);
    }
}
