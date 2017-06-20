<?php

namespace Ds\Component\Security\Model\Attribute\Accessor;

/**
 * Trait Subject
 */
trait Subject
{
    /**
     * Set subject
     *
     * @param string $subject
     * @return object
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Get subject
     *
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }
}
