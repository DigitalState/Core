<?php

namespace Ds\Component\Camunda\Model\Attribute;

use SimpleXMLElement;

/**
 * Trait Xml
 *
 * @package Ds\Component\Camunda
 */
trait Xml
{
    /**
     * @var \SimpleXMLElement
     */
    private $xml; # region accessors

    /**
     * Set xml
     *
     * @param \SimpleXMLElement $xml
     * @return object
     */
    public function setXml(?SimpleXMLElement $xml)
    {
        $this->xml = $xml;

        return $this;
    }

    /**
     * Get xml
     *
     * @return \SimpleXMLElement
     */
    public function getXml(): ?SimpleXMLElement
    {
        return $this->xml;
    }

    # endregion
}
