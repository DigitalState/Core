<?php

namespace Ds\Component\Camunda\Model;

use stdClass;

/**
 * Class Variable
 *
 * @package Ds\Component\Camunda
 */
final class Variable implements Model
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
    public function __construct(?string $name = null, $value = null, ?string $type = self::TYPE_STRING, ?stdClass $valueInfo = null)
    {
        $this
            ->setName($name)
            ->setValue($value)
            ->setType($type)
            ->setValueInfo($valueInfo);
    }
}
