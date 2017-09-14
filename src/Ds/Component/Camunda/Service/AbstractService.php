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
                        $model->{'set'.ucfirst($local)}(new DateTime($object->$remote));
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
                    $object->$remote = null;
                    $value = $model->{'get'.ucfirst($local)}();

                    if ($value) {
                        $object->$remote = $value->format('Y-m-d H:i:s');
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
     * Set host
     *
     * @param string $host
     * @return \Ds\Component\Camunda\Service\Service
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
    protected $authorization; # region accessors

    /**
     * Set authorization
     *
     * @param array $authorization
     * @return \Ds\Component\Camunda\Service\Service
     */
    public function setAuthorization(array $authorization = [])
    {
        $this->authorization = $authorization;

        return $this;
    }

    # endregion

    /**
     * Constructor
     *
     * @param \GuzzleHttp\ClientInterface $client
     * @param string $host
     * @param array $authorization
     */
    public function __construct(ClientInterface $client, $host = null, array $authorization = [])
    {
        $this->client = $client;
        $this->host = $host;
        $this->authorization = $authorization;
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

        if (!isset($options['headers']['Content-Type'])) {
            $options['headers']['Content-Type'] = 'application/json';
        }

        if (!isset($options['headers']['Accept'])) {
            $options['headers']['Accept'] = 'application/json';
        }

        if (!isset($options['headers']['Authorization']) && $this->authorization) {
            $options['headers']['Authorization'] = $this->authorization;
        }

        $response = $this->client->request($method, $uri, $options);
        $body = (string) $response->getBody();

        if ('' !== $body) {
            try {
                $body = \GuzzleHttp\json_decode($body);
            } catch (InvalidArgumentException $exception) {
                throw new UnexpectedValueException('Service response is not valid.', 0, $exception);
            }
        }

        return $body;
    }
}
