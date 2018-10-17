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
 * - "generic", meaning it is securing the access to something generic.
 * - "entity", meaning it is securing the access to an entity.
 * - "property", meaning it is securing the access to an entity property.
 *
 * The `value` property is a string and is based on the `type`. If the `type`
 * equals to:
 *
 * - "entity", the `value` should be the fully-qualified class name of the
 *   entity (example: "AppBundle\Entity\User").
 * - "property", the `value` should be the fully-qualified class name of the
 *   entity, followed by a period and the property name (example:
 *   "AppBundle\Entity\User.uuid").
 * - "generic", the `value` should be an arbitrary string that is unique.
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
 * - "EXECUTE" meaning the user ia allowed to execute the generic permission.
 *
 * @package Ds\Component\Security
 * @example The cache can be cleared
 * <code>
 * {
 *     "key": "cache_clear",
 *     "attributes": ["EXECUTE"],
 *     "type": "generic",
 *     "value": "CacheClear",
 *     "title": "Clear cache"
 * }
 * </code>
 * @example The user entity can be browsed, read, edited, added or deleted
 * <code>
 * {
 *     "key": "user",
 *     "attributes": ["BROWSE", "READ", "EDIT", "ADD", "DELETE"],
 *     "type": "entity",
 *     "value": "AppBundle\Entity\User",
 *     "title": "User entity"
 * }
 * </code>
 * @example The user uuid property can be browsed, read or edited
 * <code>
 * {
 *     "key": "user_uuid",
 *     "attributes": ["BROWSE", "READ", "EDIT"],
 *     "type": "property",
 *     "value": "AppBundle\Entity\User.uuid",
 *     "title": "User uuid property"
 * }
 * </code>
 */
class Permission
{
    use Attribute\Key;
    use Attribute\Attributes;
    use Attribute\Type;
    use Attribute\Value;
    use Attribute\Title;

    /**
     * @const string The types
     */
    const GENERIC = 'generic';
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
     * @param string $key
     * @param array $attributes
     * @param string $type
     * @param string $value
     * @param string $title
     * @throws \DomainException
     */
    public function __construct($key, array $attributes, $type, $value, $title = null)
    {
        foreach ($attributes as $attribute) {
            if (!in_array($attribute, [static::BROWSE, static::READ, static::EDIT, static::ADD, static::DELETE, static::EXECUTE], true)) {
                throw new DomainException('Permission attribute does not exist.');
            }
        }

        if (!in_array($type, [static::GENERIC, static::ENTITY, static::PROPERTY], true)) {
            throw new DomainException('Permission type does not exist.');
        }

        $this->key = $key;
        $this->attributes = $attributes;
        $this->type = $type;
        $this->value = $value;
        $this->title = $title;
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
