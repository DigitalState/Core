<?php

namespace Ds\Component\Database\Behat\Context;

use Behat\Behat\Context\Context;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Tools\SchemaTool;

/**
 * Class SchemaContext
 */
class SchemaContext implements Context
{
    /**
     * @var \Doctrine\Common\Persistence\ManagerRegistry
     */
    protected $doctrine;

    /**
     * @var \Doctrine\Common\Persistence\ObjectManager
     */
    protected $manager;

    /**
     * @var \Doctrine\ORM\Tools\SchemaTool
     */
    protected $schemaTool;

    /**
     * @var array
     */
    protected $classes;

    /**
     * Constructor
     *
     * @param \Doctrine\Common\Persistence\ManagerRegistry $doctrine
     */
    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
        $this->manager = $doctrine->getManager();
        $this->schemaTool = new SchemaTool($this->manager);
        $this->classes = $this->manager->getMetadataFactory()->getAllMetadata();
    }

    /**
     * Create schema
     *
     * @BeforeScenario @createSchema
     */
    public function createSchema()
    {
        $this->schemaTool->createSchema($this->classes);
    }

    /**
     * Drop schema
     *
     * @AfterScenario @dropSchema
     */
    public function dropSchema()
    {
        $this->schemaTool->dropSchema($this->classes);
    }
}
