<?php

namespace Ds\Component\Api\Service;

use DateTime;
use Ds\Component\Api\Model\Model;
use GuzzleHttp\ClientInterface;
use InvalidArgumentException;
use LogicException;
use stdClass;
use UnexpectedValueException;

/**
 * Class AbstractService
 *
 * @package Ds\Component\Api
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
     * @return \Ds\Component\Api\Model\Model
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
                    case 'createdAt':
                    case 'updatedAt':
                    case 'lastLogin':
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
     * @param \Ds\Component\Api\Model\Model $model
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
                case 'createdAt':
                case 'updatedAt':
                case 'lastLogin':
                    $object->$remote = null;
                    $value = $model->{'get'.ucfirst($local)}();

                    if ($value) {
                        $object->$remote = $value->format('Y-m-d\TH:i:sP');
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
    protected $proxy;

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
    protected $authorization; # region accessors

    /**
     * {@inheritdoc}
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
     * @param string $proxy
     * @param string $host
     * @param array $authorization
     */
    public function __construct(ClientInterface $client, $proxy, $host = null, array $authorization = [])
    {
        $this->client = $client;
        $this->proxy = $proxy;
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
        $options['headers']['Host'] = $this->proxy;
        $options['headers']['Content-Type'] = 'application/json';
        $options['headers']['Accept'] = 'application/json';

        if ($this->authorization) {
            $options['headers']['Authorization'] = $this->authorization;
        }

        $response = $this->client->request($method, $uri, $options);

        try {
            $data = \GuzzleHttp\json_decode($response->getBody());
        } catch (InvalidArgumentException $exception) {
            throw new UnexpectedValueException('Service response is not valid.', 0, $exception);
        }

        return $data;
    }
}
