<?php

namespace Ds\Component\Formio\Query\Attribute;

/**
 * Trait Dryrun
 *
 * @package Ds\Component\Formio
 */
trait Dryrun
{
    /**
     * @var string
     */
    private $dryrun; # region accessors

    /**
     * Set dryrun
     *
     * @param boolean $dryrun
     * @return object
     */
    public function setDryrun(?bool $dryrun)
    {
        $this->dryrun = $dryrun;
        $this->_dryrun = null !== $dryrun;

        return $this;
    }

    /**
     * Get dryrun
     *
     * @return string
     */
    public function getDryrun(): ?bool
    {
        return $this->dryrun;
    }

    # endregion

    /**
     * @var boolean
     */
    private $_dryrun;
}
