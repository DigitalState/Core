<?php

namespace Ds\Component\Database\Test\Context;

use Behat\Behat\Context\Context;
use Symfony\Component\Process\Process;

/**
 * Class FixtureContext
 *
 * @package Ds\Component\Database
 */
class FixtureContext implements Context
{
    /**
     * Load Fixtures
     *
     * @BeforeScenario @loadFixtures
     */
    public function loadFixtures()
    {
        $process = new Process('php bin/console doctrine:fixtures:load --env=test --fixtures=/srv/api-platform/src/AppBundle/Fixtures/ORM --no-interaction');
        $process->run();
    }
}
