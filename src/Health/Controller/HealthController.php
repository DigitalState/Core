<?php

namespace Ds\Component\Health\Controller;

use Ds\Component\Health\Exception\InvalidAliasException;
use Ds\Component\Health\Service\HealthService;
use stdClass;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use Symfony\Component\Routing\Annotation\Route;

/**
 * Class HealthController
 *
 * @package Ds\Component\Health
 */
final class HealthController
{
    /**
     * @const string
     */
    const TIMESTAMP_FORMAT = 'Y-m-d\TH:i:sP';

    /**
     * @var \Ds\Component\Health\Service\HealthService
     */
    private $healthService;

    /**
     * Constructor
     *
     * @param \Ds\Component\Health\Service\HealthService $healthService
     */
    public function __construct(HealthService $healthService)
    {
        $this->healthService = $healthService;
    }

    /**
     * Action
     *
     * @Route(path="/system/health", methods={"GET"})
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function cget(): JsonResponse
    {
        $statuses = $this->healthService->check();
        $data = $statuses->toObject();
        $data->timestamp = $data->timestamp->format(static::TIMESTAMP_FORMAT);
        $data->statuses = new stdClass;

        foreach ($data->collection as $status) {
            $status->timestamp = $status->timestamp->format(static::TIMESTAMP_FORMAT);
            $alias = $status->alias;
            unset($status->alias);
            $data->statuses->{$alias} = $status;
        }

        unset($data->collection);

        return new JsonResponse($data);
    }

    /**
     * Action
     *
     * @Route(path="/system/health/{alias}", requirements={"alias"=".+"}, methods={"GET"})
     * @param string $alias
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function get($alias): JsonResponse
    {
        $alias = str_replace('/', '.', $alias);

        try {
            $status = $this->healthService->check($alias);
        } catch (InvalidAliasException $exception) {
            throw new NotFoundHttpException('Health alias not found.', $exception);
        }

        $data = $status->toObject();
        $data->timestamp = $data->timestamp->format(static::TIMESTAMP_FORMAT);
        unset($data->alias);

        return new JsonResponse($data);
    }
}
