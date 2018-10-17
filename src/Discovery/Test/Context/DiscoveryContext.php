<?php

namespace Ds\Component\Discovery\Test\Context;

use Behat\Behat\Context\Context;
use Behat\Testwork\Hook\Scope\BeforeSuiteScope;
use Behat\Testwork\Hook\Scope\AfterSuiteScope;
use InterNations\Component\HttpMock\PHPUnit\HttpMockTrait;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use Symfony\Component\Yaml\Yaml;

/**
 * Class DiscoveryContext
 *
 * @package Ds\Component\Discovery
 */
class DiscoveryContext implements Context
{
    use HttpMockTrait;

    /**
     * Up discovery mock server
     *
     * @BeforeSuite
     */
    public static function upServer(BeforeSuiteScope $scope)
    {
        static::setUpHttpMockBeforeClass('8500', 'localhost');

        $directory = new RecursiveDirectoryIterator(__DIR__.'/../Resources/mocks');
        $files = new RecursiveIteratorIterator($directory);

        foreach ($files as $file) {
            if ($file->isDir()){
                continue;
            }

            $config = Yaml::parse(file_get_contents($file->getPathname()), Yaml::PARSE_OBJECT_FOR_MAP);

            static::$staticHttp
                ->mock
                    ->when()
                        ->methodIs($config->request->method)
                        ->pathIs($config->request->path)
                    ->then()
                        ->statusCode($config->response->status_code)
                        ->header('content-type', $config->response->headers->{'content-type'})
                        ->body( $config->response->body)
                    ->end();
        }

        static::$staticHttp->setUp();
    }

    /**
     * Down discovery mock server
     *
     * @AfterSuite
     */
    public static function downServer(AfterSuiteScope $scope)
    {
        static::tearDownHttpMockAfterClass();
    }
}
