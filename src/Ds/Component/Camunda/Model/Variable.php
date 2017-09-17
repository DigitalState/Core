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

    /**
     * Cast to object
     *
     * @param boolean $minimal
     * @return \stdClass
     */
    public function toObject($minimal = false)
    {
        $object = new stdClass;

        if (!$minimal) {
            $object->name = $this->getName();
        }

        $object->value = $this->getValue();
        $object->type = $this->getType();
        $object->valueInfo = $this->getValueInfo();

        return $object;
    }
}
