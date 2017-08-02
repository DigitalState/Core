<?php

namespace Ds\Component\Database\Test\Context;

use Behat\Behat\Context\Context;
use Symfony\Component\Process\Process;

/**
 * Class MigrationContext
 *
 * @package Ds\Component\Database
 */
class MigrationContext implements Context
{
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
