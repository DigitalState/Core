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
    use Attribute\Subject;
    use Attribute\Attributes;

    /**
     * @const string
     */
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

    /**
     * Constructor
     *
     * @param string $title
     * @param string $key
     * @param string $type
     * @param string $subject
     * @param array|string $attributes
     * @throws \DomainException
     */
    public function __construct($title, $key, $type, $subject, $attributes = [])
    {
        if (!in_array($type, [static::ENTITY, static::PROPERTY], true)) {
            throw new DomainException('Permission type does not exist.');
        }

        if (!is_array($attributes)) {
            $attributes = [$attributes];
        }

        foreach ($attributes as $attribute) {
            if (!in_array($attribute, [static::BROWSE, static::READ, static::EDIT, static::ADD, static::DELETE], true)) {
                throw new DomainException('Permission attribute does not exist.');
            }
        }

        $this->title = $title;
        $this->key = $key;
        $this->type = $type;
        $this->subject = $subject;
        $this->attributes = $attributes;
    }

    /**
     * Type cast to array
     *
     * @return \stdClass
     */
    public function toObject()
    {
        return (object) get_object_vars($this);
    }
}
