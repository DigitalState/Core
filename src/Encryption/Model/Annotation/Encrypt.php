<?php

namespace Ds\Component\Encryption\Model\Annotation;

/**
 * Class Encrypt
 *
 * @package Ds\Component\Encryption
 * @Annotation
 * @Target("PROPERTY")
 */
final class Encrypt
{
    /**
     * @var string
     */
    public $applicable;

    /**
     * Constructor
     *
     * @param array $values
     */
    public function __construct(array $values)
    {
        if (array_key_exists('value', $values)) {
            $this->applicable = $values['value'];
        } else if (array_key_exists('applicable', $values)) {
            $this->applicable = $values['applicable'];
        }
    }
}
