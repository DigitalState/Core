<?php

namespace Ds\Component\Health\Bridge\Symfony\Bundle\Action;

use stdClass;
use Symfony\Component\HttpFoundation\JsonResponse;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class PingAction
 */
class PingAction
{
    /**
     * Constructor
     */
    public function __construct()
    {
    }

    /**
     * Action
     *
     * @Method("GET")
     * @Route(path="/health/ping")
     */
    public function get()
    {
        $health = new stdClass;
        $health->ping = true;

        return new JsonResponse($health);
    }
}
