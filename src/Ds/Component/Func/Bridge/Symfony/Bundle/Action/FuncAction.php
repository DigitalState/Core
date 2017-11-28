<?php

namespace Ds\Component\Func\Bridge\Symfony\Bundle\Action;

use Ds\Component\Api\Api\Api;
use Ds\Component\Camunda\Model\Variable;
use Ds\Component\Camunda\Query\ProcessDefinitionParameters;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class FuncAction
 *
 * @package Ds\Component\Func
 */
class FuncAction
{
    /**
     * @var \Symfony\Component\HttpFoundation\RequestStack
     */
    protected $requestStack;

    /**
     * @var \Ds\Component\Api\Api\Api
     */
    protected $api;

    /**
     * Constructor
     *
     * @param \Symfony\Component\HttpFoundation\RequestStack $requestStack
     * @param \Ds\Component\Api\Api\Api $api
     */
    public function __construct(RequestStack $requestStack, Api $api)
    {
        $this->requestStack = $requestStack;
        $this->api = $api;
    }

    /**
     * Action
     *
     * @Route(path="/functions/{slug}")
     * @Security("is_granted('EXECUTE', 'functions')")
     * @param string $slug
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function get($slug)
    {
        $request = $this->requestStack->getCurrentRequest();
        $data = [
            'method' => $request->getMethod(),
            'query' => $request->query->all(),
            'headers' => $request->headers->all(),
            'body' => json_decode($request->getContent())
        ];
        $parameters = new ProcessDefinitionParameters;
        $parameters
            ->setVariables([new Variable('request', $data, Variable::TYPE_JSON)])
            ->setWithVariablesInReturn(true)
            ->setKey($slug);
        $instance = $this->api->get('camunda.process_definition')->start(null, $parameters);
        $data = $instance->getVariables('response')->getValue();
        $response = new JsonResponse((array) $data->body, $data->status->code, (array) $data->headers);

        return $response;
    }
}
