<?php

namespace Ds\Component\Statistic\Bridge\Symfony\Bundle\Action;

use Ds\Component\Statistic\Exception\InvalidAliasException;
use Ds\Component\Statistic\Service\StatisticService;
use stdClass;
use Symfony\Component\HttpFoundation\JsonResponse;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class StatisticAction
 *
 * @package Ds\Component\Statistic
 */
class StatisticAction
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
     * @Method("GET")
     * @Route(path="/statistics")
     * @Security("is_granted('BROWSE', 'statistic')")
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function cget()
    {
        $data = $this->statisticService->get();
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
     * @Method("GET")
     * @Route(path="/statistics/{alias}", requirements={"alias"=".+"})
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
