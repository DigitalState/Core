<?php

namespace Ds\Component\Security\Model;

use DomainException;
use Ds\Component\Model\Attribute;

/**
 * Class Permission
 *
 * The permission model represents a specific definition of an available
 * permission in the system. It describes what it is securing (`type` and
 * `value`), the available actions (`attributes`), and is identified by a
 * unique string (`key`).
 *
 * The `type` property is a string that contains one of the following:
 *
 * - "entity", meaning it is securing the access to an entity.
 * - "property", meaning it is securing the access to an entity property.
 * - "custom", meaning it is securing the access to something generic.
 *
 * The `value` property is a string and is based on the `type`. If the `type`
 * equals to:
 *
 * - "entity", the `value` should be the fully-qualified class name of the
 *   entity (example: "AppBundle\Entity\User").
 * - "property", the `value` should be the fully-qualified class name of the
 *   entity, followed by a period and the property name (example:
 *   "AppBundle\Entity\User.uuid").
 * - "custom", the `value` should be an arbitrary string and is unique (ex:
 *   "CacheClear").
 *
 * The `attributes` is an array of strings that contains one or more of the
 * following:
 *
 * - "BROWSE", meaning  the user is allowed to view the entity or entity
 *   property while paginating.
 * - "READ" meaning  the user is allowed to view the entity or entity property
 *   while viewing a single entity.
 * - "EDIT" meaning the user is allowed to edit the entity or entity property.
 * - "ADD" meaning the user is allowed to add an entity to a collection.
 * - "DELETE" meaning the user is allowed to delete an entity from a collection.
 *
 * @package Ds\Component\Security
 * @example The user entity can be browsed, read, edited, added or deleted
 * <code>
 * {
 *     "title": "User entity",
 *     "key": "user",
 *     "type": "entity",
 *     "value": "AppBundle\Entity\User",
 *     "attributes": ["BROWSE", "READ", "EDIT", "ADD", "DELETE"]
 * }
 * </code>
 * @example The user uuid property can be browsed, read or edited
 * <code>
 * {
 *     "title": "User uuid property",
 *     "key": "user_uuid",
 *     "type": "property",
 *     "value": "AppBundle\Entity\User.uuid",
 *     "attributes": ["BROWSE", "READ", "EDIT"]
 * }
 * </code>
 * @example The cache can be cleared
 * <code>
 * {
 *     "title": "Clear cache,
 *     "key": "cache_clear",
 *     "type": "custom",
 *     "value": "CacheClear",
 *     "attributes": ["EXECUTE"]
 * }
 * </code>
 */
class Permission
{
    use Attribute\Title;
    use Attribute\Key;
    use Attribute\Type;
    use Attribute\Value;
    use Attribute\Attributes;

    /**
     * @const string The types
     */
    const CUSTOM = 'custom';
    const ENTITY = 'entity';
    const PROPERTY = 'property';

    /**
     * @const string The attributes
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
