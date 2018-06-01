# Permission Definitions

Permission definitions describes to the ACL framework the possible access channels on resources. A resource can be a Doctrine entity mapped by ApiPlatform, a Symfony controller or action, etc.

The ACL framework is explicit in nature, meaning guarded resources exposes nothing by default. It is up to the developer to __explicitly__ describe __which__ entities are accessible, __which__ properties are accessible, etc. and __how__ they are accessible.

## Table of Contents

- [Example](#example)
- [Types](#types)
- [Attributes](#attributes)

## Example

Permission definitions are typically configured in YAML Symfony configuration files.

Below is a real world example found within the [Services Microservice](https://github.com/DigitalState/Services) of the DigitalState Platform:

__src/AppBundle/Resources/config/config.yml__

```
ds_security:
  permissions:
    service:             { entity:   AppBundle\Entity\Service,           attributes: [BROWSE, READ, EDIT, ADD, DELETE] }
    service_id:          { property: AppBundle\Entity\Service.id,        attributes: [BROWSE, READ, EDIT]              }
    service_uuid:        { property: AppBundle\Entity\Service.uuid,      attributes: [BROWSE, READ, EDIT]              }
    service_created_at:  { property: AppBundle\Entity\Service.createdAt, attributes: [BROWSE, READ, EDIT]              }
    service_updated_at:  { property: AppBundle\Entity\Service.updatedAt, attributes: [BROWSE, READ, EDIT]              }
    service_deleted_at:  { property: AppBundle\Entity\Service.deletedAt, attributes: [BROWSE, READ, EDIT]              }
```

The example above exposes the `Service` entity and some of its properties.

It essentially reads as followed: "The `Service` entity may be __browsed__, __read__, __edited__, __added__ and __deleted__. The `id`, `uuid`, `createdAt`, `updatedAt` and `deletedAt` properties can be __browsed__, __read__ and __edited__.".

Since it is explicit in nature, any other properties the `Service` entity may have cannot be accessed at all and are invisible to the user. It is also worth mentioning that, at this point, the entity is still not accessible by users. We have simply opened the channels of access. You can grant access to users through [access cards](accesses.md).

## Types

The permission definition type represents the type of resource the permission is opening an access channel for. Types essentially represents useful meta data and are used for mapping resources to permission definitions inside the ACL framework.

Currently, there are three types of permission definition: `entity`, `property` and `generic`.

### Entity

A permission definition of type `entity` opens the access channel for a Doctrine entity mapped through ApiPlatform. It uses the entity's full class name as its value. For example:

__src/AppBundle/Resources/config/config.yml__

```
ds_security:
  permissions:
    service: { entity: AppBundle\Entity\Service, attributes: [READ] }
```

The example above opens the access channel for the `AppBundle\Entity\Service` entity in `READ` mode.

### Property

A permission definition of type `property` opens the access channel for a property of a Doctrine entity mapped by ApiPlatform. It uses the full class name, followed by a dot, and finally the property name. For example:

__src/AppBundle/Resources/config/config.yml__

```
ds_security:
  permissions:
    service_id: { property: AppBundle\Entity\Service.id, attributes: [READ] }
```

The example above opens the access channel for the `id` property of the `AppBundle\Entity\Service` entity in `READ` mode.

### Generic

The permission definition of type `generic` is the most abstract type of permission definition.

This type doesn't contain any useful meta data in of itself, unlike the `entity` and `property` types. This means that this definition type does not open any access channels automatically. It is up to the developer to manually tag a resource with permission definitions of this type.

It is mostly used to open access channels for Symfony controllers and actions and is fully compatible with the `@Security` annotation of the [Symfony Security bundle](https://symfony.com/doc/current/security.html).

__src/AppBundle/Resources/config/config.yml__

```
ds_security:
  permissions:
    cache_clear: { generic: CacheClear, attributes: [EXECUTE] }
```

__src/AppBundle/Action/CacheAction.php__

```
<?php

namespace AppBundle\Action;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CacheAction
 */
class CacheAction
{
    /**
     * Clear action
     *
     * @Route(path="/cache/clear")
     * @Security("is_granted('EXECUTE', 'cache_clear')")
     */
    public function clearAction()
    {
        // Clear redis cache
    }
}

```

The example above guards the cache/clear action. This means whoever is trying to access the `/cache/clear` endpoint must be granted `EXECUTE` on the `cache_clear` permission.

## Attributes

Permission definition attributes represent the possible actions that can be done against a resource. Attributes are essentially useful meta data and in some cases, mapped to HTTP request method inside the Symfony and ApiPlatform frameworks.

Currently, there are six possible attributes for permission definitions: `BROWSE`, `READ`, `EDIT`, `ADD`, `DELETE` and`EXECUTE`.

### BROWSE

The `BROWSE` attribute exposes the HTTP __GET__ method on a collection of entities.

For example: __GET__ `/services`.

### READ

The `READ` attribute exposes the HTTP __GET__ method on a single entity.

For example: __GET__ `/services/{id}`.

### EDIT

The `EDIT` attribute exposes the HTTP __PUT__ method on a single entity.

For example: __PUT__ `{ "title": "..." }` `/services/{id}`.

### ADD

The `ADD` attribute exposes the HTTP __POST__ method on a collection of entities.

For example: __POST__ `{ "title": "..." }` `/services`.

### DELETE

The `DELETE` attribute exposes the HTTP __DELETE__ method on a single entity.

For example: __DELETE__ `/services/{id}`.

### EXECUTE

The `EXECUTE` attribute is abstract in nature, similarly to how the permission definition of type `generic` is abstract.

This attribute is mostly used with permission definitions of type `generic`, where are opening access channels to system functionality such as clearing cache, running an update, installing a module, etc.

