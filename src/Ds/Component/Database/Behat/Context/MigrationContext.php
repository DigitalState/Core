<?php

namespace Ds\Component\Database\Behat\Context;

use Behat\Behat\Context\Context;
use Symfony\Component\Process\Process;

/**
 * Class MigrationContext
 */
class MigrationContext implements Context
{
    /**
     * Constructor
     */
    public function __construct()
    {
    }

    /**
     * Run migrations
     *
     * @BeforeScenario @runMigrations
     */
    public function runMigrations()
    {
        $process = new Process('php bin/console doctrine:migrations:migrate --env=test --no-interaction');
        $process->run();
    }

    /**
     * Load Fixtures
     *
     * @BeforeScenario @loadFixtures
     */
    public function loadFixtures()
    {
        $process = new Process('php bin/console doctrine:fixtures:load --env=test --no-interaction');
        $process->run();
    }
}
