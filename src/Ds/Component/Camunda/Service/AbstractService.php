<?php

namespace Ds\Component\Camunda\Service;

use DateTime;
use Ds\Component\Camunda\Model\Model;
use GuzzleHttp\ClientInterface;
use InvalidArgumentException;
use LogicException;
use UnexpectedValueException;
use stdClass;

/**
 * Class AbstractService
 *
 * @package Ds\Component\Camunda
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
     * @return \Ds\Component\Camunda\Model\Model
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
                    case 'due':
                    case 'followUp':
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
     * @param \Ds\Component\Camunda\Model\Model $model
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
                case 'due':
                case 'followUp':
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

        if (!isset($headers['Content-Type'])) {
            $headers['Content-Type'] = 'application/json';
        }

        if (!isset($headers['Accept'])) {
            $headers['Accept'] = 'application/json';
        }

        $this->headers = $headers;
    }

    /**
     * Execute api request
     *
     * @param string $method
     * @param string $resource
     * @param array $options
     * @return mixed
     */
    protected function execute($method, $resource, array $options = [])
    {
        $uri = $this->host.$resource;

        foreach ($this->headers as $key => $value) {
            if (!isset($options['headers'][$key])) {
                $options['headers'][$key] = $value;
            }
        }

        $response = $this->client->request($method, $uri, $options);
        $data = (string) $response->getBody();

        if ('' !== $data) {
            try {
                $data = \GuzzleHttp\json_decode($data);
            } catch (InvalidArgumentException $exception) {
                throw new UnexpectedValueException('Service response is not valid.', 0, $exception);
            }
        }

        return $data;
    }
}
