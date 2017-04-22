<?php

namespace Ds\Component\Model\Accessor;

/**
 * Trait Description
 */
trait Description
{
    /**
     * Set description
     *
     * @param string $description
     * @return object
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }
}
