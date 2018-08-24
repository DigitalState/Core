<?php

namespace Ds\Component\Formio\Model\Attribute;

/**
 * Trait Settings
 *
 * @package Ds\Component\Formio
 */
trait Settings
{
    /**
     * @var object
     */
    protected $settings; # region accessors

    /**
     * Set settings
     *
     * @param object $settings
     * @return object
     */
    public function setSettings($settings)
    {
        $this->settings = $settings;

        return $this;
    }

    /**
     * Get settings
     *
     * @return object
     */
    public function getSettings()
    {
        return $this->settings;
    }

    # endregion
}
