<?php

namespace Ds\Component\Api\Query;

use stdClass;

/**
 * Trait Base
 *
 * @package Ds\Component\Api
 */
trait Base
{
    /**
     * {@inheritdoc}
     */
    public function toObject(bool $minimal = false)
    {
        $object = new stdClass;

        foreach ($this as $key => $value) {
            if ('_' === substr($key, 0, 1)) {
                continue;
            }

            if ($minimal && !$this->{'_'.$key}) {
                continue;
            }

            $object->$key = $value;
        }

        return $object;
    }
}
