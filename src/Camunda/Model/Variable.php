<?php

namespace Ds\Component\Camunda\Model;

use stdClass;

/**
 * Class Variable
 *
 * @package Ds\Component\Camunda
 */
class Variable implements Model
{
    use Attribute\Name;
    use Attribute\Value;
    use Attribute\Type;
    use Attribute\ValueInfo;

    /**
     * @const string
     */
    const TYPE_STRING = 'String';
    const TYPE_INTEGER = 'Integer';
    const TYPE_JSON = 'Json';

    /**
     * Constructor
     *
     * @param string $name
     * @param mixed $value
     * @param string $type
     * @param \stdClass $valueInfo
     */
    public function __construct($name = null, $value = null, $type = self::TYPE_STRING, stdClass $valueInfo = null)
    {
        $this
            ->setName($name)
            ->setValue($value)
            ->setType($type)
            ->setValueInfo($valueInfo);
    }
}
