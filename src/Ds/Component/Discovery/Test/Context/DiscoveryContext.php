<?php

namespace Ds\Component\Discovery\Test\Context;

use Behat\Behat\Context\Context;
use Behat\Testwork\Hook\Scope\BeforeSuiteScope;

/**
 * Class DiscoveryContext
 *
 * @package Ds\Component\Discovery
 */
class DiscoveryContext implements Context
{
    /**
     * Create discovery mock server
     *
     * @BeforeSuite
     */
    public static function createServer(BeforeSuiteScope $scope)
    {

    }
}
