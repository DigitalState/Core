<?php

namespace Ds\Component\Http\Test\Context;

use Behat\Behat\Context\Context;


/**
 * Class JsonContext
 *
 * @package Ds\Component\Http
 */
class JsonContext implements Context
{
    /**
     * @var mixed
     */
    protected $result; # region accessors

    /**
     * Set result
     *
     * @param mixed $result
     * @return \Ds\Component\Http\Test\Context\JsonContext
     */
    public function setResult($result)
    {
        $this->result = $result;

        return $this;
    }

    # endregion

    /**
     * @Then the response should be a collection
     * @return boolean
     */
    public function theResponseShouldBeACollection()
    {
        return true;
    }

    /**
     * @Then the response collection should count :count items
     * @return boolean
     */
    public function theResponse($count)
    {
        return true;
    }


}
