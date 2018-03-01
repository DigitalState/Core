<?php

namespace Ds\Component\Formio\Service;

use Ds\Component\Formio\Exception\RequestException;
use Ds\Component\Formio\Exception\ResponseException;
use Ds\Component\Formio\Exception\ValidationException;
use Ds\Component\Formio\Model\Model;
use GuzzleHttp\Exception\ClientException;
use stdClass;
use DateTime;
use GuzzleHttp\ClientInterface;
use LogicException;
use InvalidArgumentException;

/**
 * Class AbstractService
 *
 * @package Ds\Component\Formio
 */
abstract class AbstractService implements Service
{
    /**
     * @const string
     */
    const MODEL = null;

    /**
     * @var array
     */
    protected static $map = [];

    /**
     * Cast object to model
     *
     * @param \stdClass $object
     * @return \Ds\Component\Formio\Model\Model
     * @throws \LogicException
     */
    public static function toModel(stdClass $object)
    {
        if (null === static::MODEL) {
            throw new LogicException('Model class is not defined.');
        }

        $class = static::MODEL;
        $model = new $class;

        foreach (static::$map as $local => $remote) {
            if (is_int($local)) {
                $local = $remote;
            }

            if (property_exists($object, $remote)) {
                switch ($local) {
                    case 'created':
                    case 'updated':
                        if (null !== $object->$remote) {
                            $model->{'set' . ucfirst($local)}(new DateTime($object->$remote));
                        }

                        break;

                    default:
                        $model->{'set'.ucfirst($local)}($object->$remote);
                }
            }
        }

        return $model;
    }

    /**
     * Cast model to object
     *
     * @param \Ds\Component\Formio\Model\Model $model
     * @return stdClass
     * @throws \LogicException
     */
    public static function toObject(Model $model)
    {
        if (null === static::MODEL) {
            throw new LogicException('Model class is not defined.');
        }

        $object = new stdClass;

        foreach (static::$map as $local => $remote) {
            if (is_int($local)) {
                $local = $remote;
            }

            switch ($local) {
                case 'created':
                case 'updated':
                    $object->$remote = null;
                    $value = $model->{'get'.ucfirst($local)}();

                    if (null !== $value) {
                        $object->$remote = $value->format('Y-m-dTH:i:s');
                    }

                    break;

                default:
                    $object->$remote = $model->{'get'.ucfirst($local)}();
            }
        }

        return $object;
    }

    /**
     * @var \GuzzleHttp\ClientInterface
     */
    protected $client;

    /**
     * @var string
     */
    protected $host; # region accessors

    /**
     * {@inheritdoc}
     */
    public function setHost($host = null)
    {
        $this->host = $host;

        return $this;
    }

    # endregion

    /**
     * @var array
     */
    protected $headers; # region accessors

    /**
     * {@inheritdoc}
     */
    public function setHeaders(array $headers = [])
    {
        $this->headers = $headers;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setHeader($name, $value)
    {
        $this->headers[$name] = $value;

        return $this;
    }

    # endregion

    /**
     * Constructor
     *
     * @param \GuzzleHttp\ClientInterface $client
     * @param string $host
     * @param array $headers
     */
    public function __construct(ClientInterface $client, $host = null, array $headers = [])
    {
        $this->client = $client;
        $this->host = $host;
        $this->headers = $headers;
    }

    /**
     * Execute api request
     *
     * @param string $method
     * @param string $resource
     * @param array $options
     * @return mixed
     * @throws \Ds\Component\Formio\Exception\RequestException
     * @throws \Ds\Component\Formio\Exception\ResponseException
     * @throws \Ds\Component\Formio\Exception\ValidationException
     */
    protected function execute($method, $resource, array $options = [])
    {
        $uri = $this->host.$resource;

        if ($this->headers) {
            if (!array_key_exists('headers', $options)) {
                $options['headers'] = [];
            }

            foreach ($this->headers as $key => $value) {
                if (!array_key_exists($key, $options['headers'])) {
                    $options['headers'][$key] = $value;
                }
            }
        }

        // @todo Remove this once we align formio and apip jwt tokens
        unset($options['headers']['Authorization']);

        try {
            $response = $this->client->request($method, $uri, $options);
        } catch (ClientException $exception) {
            $response = $exception->getResponse();

            switch ($response->getStatusCode()) {
                case 400:
                    $validation = new ValidationException('Data is not valid.', 0, $exception);
                    $data = \GuzzleHttp\json_decode($response->getBody());
                    $validation->setErrors($data->details);
                    throw $validation;
                    break;

                default:
                    throw new RequestException('Request failed.', 0, $exception);
            }
        }

        // @todo Instead of this switch case, refactor execute() method to return header and body, instead of just body.
        switch ($resource) {
            case AuthenticationService::RESOURCE_LOGIN:
                $data = $response->getHeader('x-jwt-token')[0];
                break;

            default:
                $data = (string) $response->getBody();

                if ('' !== $data) {
                    try {
                        $data = \GuzzleHttp\json_decode($response->getBody());
                    } catch (InvalidArgumentException $exception) {
                        throw new ResponseException('Service response is not valid.', 0, $exception);
                    }
                }
        }

        return $data;
    }
}
