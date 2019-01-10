<?php

namespace Ds\Component\Console\Test\Context;

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Exception;

/**
 * Class ConsoleContext
 *
 * @package Ds\Component\Console
 */
final class ConsoleContext implements Context
{
    /**
     * @var string
     */
    private $output;

    /**
     * @Given I have a console at :directory
     * @param string $directory
     * @throws \Exception
     */
    public function iHaveACconsoleAt($directory)
    {
        if (!is_dir($directory)) {
            throw new Exception('Directory "'.$directory.'" does not exist.');
        }

        chdir($directory);
    }

    /**
     * @When I run the command :command
     * @param string $command
     * @throws \Exception
     */
    public function iRunTheCommand($command)
    {
        exec($command, $output, $status);

        if (0 !== $status) {
            throw new Exception('Command "'.$command.'" did not execute successfully.');
        }

        $this->output = $output;
    }

    /**
     * @Then I should get the following output:
     * @param \Behat\Gherkin\Node\PyStringNode $string
     * @throws \Exception
     */
    public function iShouldGetTheFollowingOutput(PyStringNode $string)
    {
        if (implode("\n", $this->output) !== (string) $string) {
            throw new Exception('Command output does not match expected output.');
        }
    }
}
