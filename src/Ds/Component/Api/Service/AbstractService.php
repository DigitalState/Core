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

                    case 'individual':
                        // @todo reverse load for relationships
                        break;

                    case 'organization':
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

                default:
                    $object->$remote = $value;
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
     */
    protected function execute($method, $resource, array $options = [])
    {
        $uri = $this->host.$resource;

        if (!isset($options['headers']['Content-Type'])) {
            $options['headers']['Content-Type'] = $this->headers['Content-Type'];
        }

        if (!isset($options['headers']['Accept'])) {
            $options['headers']['Accept'] = $this->headers['Accept'];
        }

        if (!isset($options['headers']['Authorization']) && array_key_exists('Authorization', $this->headers)) {
            $options['headers']['Authorization'] = $this->headers['Authorization'];
        }

        $response = $this->client->request($method, $uri, $options);
        $body = (string) $response->getBody();

        if ('' !== $body) {
            try {
                $data = \GuzzleHttp\json_decode($body);
            } catch (InvalidArgumentException $exception) {
                throw new UnexpectedValueException('Service response is not valid.', 0, $exception);
            }
        }

        return $data;
    }
}
