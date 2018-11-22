<?php

namespace Ds\Component\Database\Test\Context;

use Behat\Behat\Context\Context;
use Symfony\Component\Process\Process;

/**
 * Class MigrationContext
 *
 * @package Ds\Component\Database
 */
final class MigrationContext implements Context
{
    /**
     * Up migrations
     *
     * @BeforeScenario @upMigrations
     */
    public function upMigrations()
    {
        $process = new Process('php bin/console doctrine:migrations:migrate --env=test --no-interaction');
        $process->run();
    }

    /**
     * Down migrations
     *
     * @AfterScenario @downMigrations
     */
    public function downMigrations()
    {
        $process = new Process('php bin/console doctrine:migrations:migrate --env=test --no-interaction first');
        $process->run();
    }
}
