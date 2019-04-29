<?php

namespace Ds\Component\Query\Controller\System;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use UnexpectedValueException;

use Symfony\Component\Routing\Annotation\Route;

/**
 * Class QueryController
 */
final class QueryController
{
    /**
     * @var \GuzzleHttp\ClientInterface
     */
    private $client;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->client = new Client;
    }

    /**
     * Query endpoint
     *
     * @Route(path="/system/{entity}/query", methods={"POST"})
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param string $entity
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function post(Request $request, $entity)
    {
        try {
            $get = $this->client->get($request->getSchemeAndHttpHost().'/system/'.$entity, [
                'headers' => [
                    'accept' => $request->headers->get('accept'),
                    'content-type' => $request->headers->get('content-type'),
                    'authorization' => $request->headers->get('authorization')
                ],
                'query' => $request->query->all(),
                'body' => $request->getContent()
            ]);
        } catch (ClientException $exception) {
            throw new UnexpectedValueException('Query did not execute successfully.');
        }

        $response = new Response((string) $get->getBody());
        $response->headers->set('content-type', $request->headers->get('content-type'));

        return $response;
    }
}
