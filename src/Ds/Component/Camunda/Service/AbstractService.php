<?php

namespace Ds\Component\Camunda\Service;

use DateTime;
use Ds\Component\Camunda\Model\Model;
use Ds\Component\Camunda\Model\Variable;
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
                    case 'deploymentTime':
                        if (null !== $object->$remote) {
                            $model->{'set' . ucfirst($local)}(new DateTime($object->$remote));
                        }

                        break;

                    case 'variables':
                        foreach ($object->$remote as $name => $variable) {
                            if (Variable::TYPE_JSON === $variable->type) {
                                $variable->value = json_decode($variable->value);
                            }

                            $model->addVariable(new Variable($name, $variable->value, $variable->type, $variable->valueInfo));
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
                case 'deploymentTime':
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
