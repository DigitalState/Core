<?php

namespace Ds\Component\Security\Acl;

use DomainException;

/**
 * Class Permission
 */
class Permission
{
    /**
     * @const string
     */
    const ENTItY = 'entity';
    const FIELD = 'field';

    /**
     * @const string
     */
    const BROWSE = 'browse';
    const READ = 'read';
    const EDIT = 'edit';
    const ADD = 'add';
    const DELETE = 'delete';

    /**
     * @var string
     */
    protected $type; # region accessors

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    # endregion

    /**
     * @var string
     */
    protected $subject; # region accessors

    /**
     * Get subject
     *
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    # endregion

    /**
     * @var array
     */
    protected $attributes; # region accessors

    /**
     * Get attributes
     *
     * @return array
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    # endregion

    /**
     * Constructor
     *
     * @param string $type
     * @param string $subject
     * @param array|string $attributes
     * @throws \DomainException
     */
    public function __construct($type, $subject, $attributes = [])
    {
        if (!in_array($type, [static::ENTItY, static::FIELD], true)) {
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

        $this->type = $type;
        $this->subject = $subject;
        $this->attributes = $attributes;
    }

    public function toArray()
    {
        return get_object_vars($this);
    }
}
