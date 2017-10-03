<?php

namespace Ds\Component\Health\Bridge\Symfony\Bundle\Action;

use Ds\Component\Health\Service\HealthService;
use stdClass;
use Symfony\Component\HttpFoundation\JsonResponse;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class HealthAction
 *
 * @package Ds\Component\Health
 */
class HealthAction
{
    /**
     * @const string
     */
    const TIMESTAMP_FORMAT = 'Y-m-d\TH:i:sP';

    /**
     * @var \Ds\Component\Health\Service\HealthService
     */
    protected $healthService;

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
     * @Method("GET")
     * @Route(path="/health")
     * @Security("is_granted('BROWSE', 'health')")
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function cget()
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
     * @Method("GET")
     * @Route(path="/health/{alias}", requirements={"alias"=".+"})
     * @Security("is_granted('READ', 'health')")
     * @param string $alias
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function get($alias)
    {
        $alias = str_replace('/', '.', $alias);
        $status = $this->healthService->check($alias);
        $data = $status->toObject();
        $data->timestamp = $data->timestamp->format(static::TIMESTAMP_FORMAT);
        unset($data->alias);

        return new JsonResponse($data);
    }
}
