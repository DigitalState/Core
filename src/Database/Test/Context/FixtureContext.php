<?php

namespace Ds\Component\Database\Test\Context;

use Behat\Behat\Context\Context;
use Symfony\Component\Process\Process;

/**
 * Class FixtureContext
 *
 * @package Ds\Component\Database
 */
final class FixtureContext implements Context
{
    /**
     * Load Fixtures
     *
     * @BeforeFeature
     */
    public static function loadFixtures()
    {
        $process = new Process('FIXTURES=test php bin/console doctrine:fixtures:load --env=test --no-interaction');
        $process->run();
    }
}
