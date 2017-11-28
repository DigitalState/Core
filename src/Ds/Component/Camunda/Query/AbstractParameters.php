<?php

namespace Ds\Component\Camunda\Query;

use GuzzleHttp;
use Ds\Component\Camunda\Model\Variable;
use stdClass;

/**
 * Class AbstractParameters
 *
 * @package Ds\Component\Camunda
 */
abstract class AbstractParameters implements Parameters
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

            switch ($key) {
                case 'variables':
                    $object->$key = [];

                    foreach ($value as $name => $variable) {
                        $object->$key[$variable->getName()] = (object) [
                            'name' => $variable->getName(),
                            'value' => $variable->getValue(),
                            'type' => $variable->getType(),
                            'valueInfo' => $variable->getValueInfo()
                        ];
                    }

                    break;

                default:
                    $object->$key = $value;
            }
        }

        return $object;
    }
}
