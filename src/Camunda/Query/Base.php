<?php

namespace Ds\Component\Camunda\Query;

use GuzzleHttp;
use Ds\Component\Camunda\Model\Variable;
use stdClass;

/**
 * Trait Base
 *
 * @package Ds\Component\Camunda
 */
trait Base
{
    /**
     * {@inheritdoc}
     */
    public function toObject(bool $minimal = false, $type = 'query')
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

                case 'cascade':
                case 'unassigned':
                    if ('query' === $type) {
                        $object->$key = $value ? 'true' : 'false';
                    } else {
                        $object->$key = $value;
                    }

                    break;

                case 'tenantIdIn':
                case 'candidateGroups':
                    if ('query' === $type) {
                        $object->$key = implode(',', $value);
                    } else {
                        $object->$key = $value;
                    }

                    break;

                case 'createdBefore':
                case 'createdAfter':
                case 'dueBefore':
                case 'dueAfter':
                    $object->$key = $value->format('Y-m-d\TH:i:s.v+0000');
                    break;

                default:
                    $object->$key = $value;
            }
        }

        return $object;
    }
}
