<?php

namespace Ds\Component\Health\Bridge\Symfony\Bundle\Action;

use Ds\Component\Health\Service\HealthService;
use stdClass;
use Symfony\Component\HttpFoundation\JsonResponse;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class HealthAction
 *
 * @package Ds\Component\Health
 */
class HealthAction
{
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
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function cget()
    {
        $statuses = $this->healthService->check();
        $data = $statuses->toObject();
        $data->statuses = new stdClass;

        foreach ($data->collection as $alias => $status) {
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
     * @param string $alias
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function get($alias)
    {
        if (null !== $alias) {
            $alias = str_replace('/', '.', $alias);
        }

        $status = $this->healthService->check($alias);
        $data = $status->toObject();
        unset($data->alias);

        return new JsonResponse($data);
    }
}
