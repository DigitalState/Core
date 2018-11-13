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
 * Trait Base
 *
 * @package Ds\Component\Api
 */
trait Base
{
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

                    case 'individual':
                        // @todo reverse load for relationships
                        break;

                    case 'organization':
                        // @todo reverse load for relationships
                        break;

                    case 'permissions':
                        // @todo reverse load for relationships
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

            $value = $model->{'get'.ucfirst($local)}();

            switch ($local) {
                case 'createdAt':
                case 'updatedAt':
                    if ($value) {
                        $object->$remote = $value->format('Y-m-d\TH:i:sP');
                    }

                    break;

                case 'lastLogin':
                    $object->$remote = null;

                    if ($value) {
                        $object->$remote = $value->format('Y-m-d\TH:i:sP');
                    }

                    break;

                case 'individual':
                    $object->$remote = '/individuals/'.$value->getUuid();
                    break;

                case 'organization':
                    $object->$remote = '/organizations/'.$value->getUuid();
                    break;

                case 'permissions':
                    $object->$remote = [];

                    foreach ($value as $permission) {
                        $object->$remote[] = PermissionService::toObject($permission);
                    }

                    break;

                default:
                    $object->$remote = $value;
            }
        }

        return $object;
    }

    /**
     * @var \GuzzleHttp\ClientInterface
     */
    private $client;

    /**
     * @var string
     */
    private $host; # region accessors

    /**
     * {@inheritdoc}
     */
    public function setHost(string $host)
    {
        $this->host = $host;

        return $this;
    }

    # endregion

    /**
     * @var array
     */
    private $headers; # region accessors

    /**
     * {@inheritdoc}
     */
    public function setHeaders(array $headers)
    {
        $this->headers = $headers;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setHeader(string $name, string $value)
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
    public function __construct(ClientInterface $client, string $host = null, array $headers = [])
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
