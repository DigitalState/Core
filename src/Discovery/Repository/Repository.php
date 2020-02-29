<?php

namespace Ds\Component\Discovery\Repository;

use Doctrine\Common\Persistence\ObjectRepository;
use Ds\Component\Discovery\Collection\AdapterCollection;

/**
 * Class Repository
 *
 * @package Ds\Component\Discovery
 */
abstract class Repository implements ObjectRepository
{
    /**
     * @var AdapterCollection
     */
    protected $adapterCollection;

    /**
     * @var string
     */
    protected $adapter;

    /**
     * Constructor
     *
     * @param AdapterCollection $adapterCollection
     * @param string $adapter
     */
    public function __construct(AdapterCollection $adapterCollection, string $adapter)
    {
        $this->adapterCollection = $adapterCollection;
        $this->adapter = $adapter;
    }
}
