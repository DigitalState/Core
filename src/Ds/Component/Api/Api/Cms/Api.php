<?php

namespace Ds\Component\Api\Api\Cms;

use Ds\Component\Api\Service\Cms;
use GuzzleHttp\ClientInterface;

/**
 * Class Api
 *
 * @package Ds\Component\Api
 */
class Api
{
    /**
     * @var \Ds\Component\Api\Service\Cms\DataService
     */
    public $data;

    /**
     * @var \Ds\Component\Api\Service\Cms\FileService
     */
    public $file;

    /**
     * @var \Ds\Component\Api\Service\Cms\TextService
     */
    public $text;

    /**
     * Constructor
     *
     * @param \GuzzleHttp\ClientInterface $client
     * @param string $host
     */
    public function __construct(ClientInterface $client, $host = null)
    {
        $this->data = new Cms\DataService($client, $host);
        $this->file = new Cms\FileService($client, $host);
        $this->text = new Cms\TextService($client, $host);
    }

    /**
     * Set host
     *
     * @param string $host
     * @return \Ds\Component\Api\Api\Cms\Api
     */
    public function setHost($host)
    {
        $this->data->setHost($host);
        $this->file->setHost($host);
        $this->text->setHost($host);

        return $this;
    }
}
