<?php

namespace Ds\Component\Statistic\Controller;

use Ds\Component\Statistic\Exception\InvalidAliasException;
use Ds\Component\Statistic\Service\StatisticService;
use stdClass;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * Class StatisticController
 *
 * @package Ds\Component\Statistic
 */
class StatisticController
{
    /**
     * @const string
     */
    const TIMESTAMP_FORMAT = 'Y-m-d\TH:i:sP';

    /**
     * @var \Ds\Component\Statistic\Service\StatisticService
     */
    protected $statisticService;

    /**
     * Constructor
     *
     * @param \Ds\Component\Statistic\Service\StatisticService $statisticService
     */
    public function __construct(StatisticService $statisticService)
    {
        $this->statisticService = $statisticService;
    }

    /**
     * Action
     *
     * @Route(path="/statistics", methods={"GET"})
     * @Security("is_granted('BROWSE', 'statistic')")
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function cget()
    {
        $data = $this->statisticService->getAll();
        $data = $data->toObject();
        $data->timestamp = $data->timestamp->format(static::TIMESTAMP_FORMAT);
        $data->data = new stdClass;

        foreach ($data->collection as $datum) {
            $datum->timestamp = $datum->timestamp->format(static::TIMESTAMP_FORMAT);
            $alias = $datum->alias;
            unset($datum->alias);
            $data->data->{$alias} = $datum;
        }

        unset($data->collection);

        return new JsonResponse($data);
    }

    /**
     * Action
     *
     * @Route(path="/statistics/{alias}", requirements={"alias"=".+"}, methods={"GET"})
     * @Security("is_granted('READ', 'statistic')")
     * @param string $alias
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function get($alias)
    {
        $alias = str_replace('/', '.', $alias);

        try {
            $datum = $this->statisticService->get($alias);
        } catch (InvalidAliasException $exception) {
            throw new NotFoundHttpException('Statistic alias not found.', $exception);
        }

        $data = $datum->toObject();
        $data->timestamp = $data->timestamp->format(static::TIMESTAMP_FORMAT);
        unset($data->alias);

        return new JsonResponse($data);
    }
}
