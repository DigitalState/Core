<?php

namespace Ds\Component\Model\Attribute\Accessor;

/**
 * Trait Alias
 */
trait Alias
{
    /**
     * Set alias
     *
     * @param string $alias
     * @return object
     */
    public function setAlias($alias)
    {
        $this->alias = $alias;

        return $this;
    }

    /**
     * Get alias
     *
     * @return string
     */
    public function getAlias()
    {
        return $this->alias;
    }
}
