<?php

namespace Ds\Component\Security\Model;

use DomainException;

/**
 * Class Permission
 */
class Permission
{
    use Attribute\Title;
    use Attribute\Key;
    use Attribute\Type;
    use Attribute\Value;
    use Attribute\Attributes;

    /**
     * @const string
     */
    const CUSTOM = 'custom';
    const ENTITY = 'entity';
    const PROPERTY = 'property';

    /**
     * @const string
     */
    const BROWSE = 'BROWSE';
    const READ = 'READ';
    const EDIT = 'EDIT';
    const ADD = 'ADD';
    const DELETE = 'DELETE';
    const EXECUTE = 'EXECUTE';

    /**
     * Constructor
     *
     * @param string $title
     * @param string $key
     * @param string $type
     * @param string $value
     * @param array|string $attributes
     * @throws \DomainException
     */
    public function __construct($title, $key, $type, $value, $attributes = [])
    {
        if (!in_array($type, [static::CUSTOM, static::ENTITY, static::PROPERTY], true)) {
            throw new DomainException('Permission type does not exist.');
        }

        if (!is_array($attributes)) {
            $attributes = [$attributes];
        }

        foreach ($attributes as $attribute) {
            if (!in_array($attribute, [static::BROWSE, static::READ, static::EDIT, static::ADD, static::DELETE, static::EXECUTE], true)) {
                throw new DomainException('Permission attribute does not exist.');
            }
        }

        $this->title = $title;
        $this->key = $key;
        $this->type = $type;
        $this->value = $value;
        $this->attributes = $attributes;
    }

    /**
     * Type cast to object
     *
     * @return \stdClass
     */
    public function toObject()
    {
        return (object) get_object_vars($this);
    }
}
