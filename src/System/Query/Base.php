<?php

namespace Ds\Component\System\Query;

use stdClass;

/**
 * Trait Base
 *
 * @package Ds\Component\System
 */
trait Base
{
    /**
     * {@inheritdoc}
     */
    public function toObject($minimal = false)
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
