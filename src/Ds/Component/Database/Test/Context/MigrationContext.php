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
     * Load migrations
     *
     * @BeforeScenario @loadMigrations
     */
    public function loadMigrations()
    {
        $process = new Process('php bin/console doctrine:migrations:migrate --env=test --no-interaction');
        $process->run();
    }
}
