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

```
ds_security:
  permissions:
    service:             { attributes: [BROWSE, READ, EDIT, ADD, DELETE],  entity:    AppBundle\Entity\Service,            title: app.permissions.service            }
    service_id:          { attributes: [BROWSE, READ, EDIT],               property:  AppBundle\Entity\Service.id,         title: app.permissions.service.id         }
    service_uuid:        { attributes: [BROWSE, READ, EDIT],               property:  AppBundle\Entity\Service.uuid,       title: app.permissions.service.uuid       }
    service_created_at:  { attributes: [BROWSE, READ, EDIT],               property:  AppBundle\Entity\Service.createdAt,  title: app.permissions.service.created_at }
    service_updated_at:  { attributes: [BROWSE, READ, EDIT],               property:  AppBundle\Entity\Service.updatedAt,  title: app.permissions.service.updated_at }
    service_deleted_at:  { attributes: [BROWSE, READ, EDIT],               property:  AppBundle\Entity\Service.deletedAt,  title: app.permissions.service.deleted_at }
```

The example above exposes the `Service` entity and some of its properties. It essentially reads as followed: "The `Service` entity may be __browsed__, __read__, __edited__, __added__ and __deleted__. The `id`, `uuid`, `createdAt`, `updatedAt` and `deletedAt` properties can be __browsed__, __read__ and __edited__.". Since it is explicit in nature, any other properties the `Service` entity may have cannot be accessed at all and are invisible to the user.

It is also worth mentioning that, at this point, the entity is still not accessible by users. We have simply opened the channels of access. You can grant access to users through [access cards](accesses.md).

## Types

A permission definition type represents the type of resource the permission is exposing. Types are essentially useful meta data and is used for mapping resources to permission definitions inside the Symfony and ApiPlatform frameworks.

Currently, there are three types of permission definitions: `entity`, `property` and `generic`.

### Entity

The permission definition of type `entity` exposes a Doctrine entity mapped through ApiPlatform. It uses the entity's full class name as its value. For example:

```
ds_security:
  permissions:
    service: { entity: AppBundle\Entity\Service, attributes: [READ] }
```

The example above exposes the `AppBundle\Entity\Service` entity.

### Property

The permission definition of type `property` exposes a property of a Doctrine entity mapped by ApiPlatform. It uses the fill class name, followed by a dot, and finally the property name. For example:

```
ds_security:
  permissions:
    service_id: { property: AppBundle\Entity\Service.id, attributes: [READ] }
```

The example above exposes the `id` property of the `AppBundle\Entity\Service` entity.

### Generic

The permission definition of type `generic` is the most abstract type of permission definition.

This type doesn't contain any useful meta data in of itself, like the `entity` and `property` types. This means that this definition type does not expose anything out of the box and is not automatically integrated with other parts of the framework. It is up to the developer to manually tag a resource with permission definitions of this type.

It is mostly used to expose Symfony controllers and actions and is fully compatible with the `@Security` annotation of the [Symfony Security bundle](https://symfony.com/doc/current/security.html).

```
ds_security:
  permissions:
    cache_clear: { generic: CacheClear, attributes: [EXECUTE] }
```

```
<?php

namespace AppBundle\Action;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
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
     * @Method("GET")
     * @Route(path="/cache/clear")
     * @Security("is_granted('EXECUTE', 'cache_clear')")
     */
    public function clear()
    {
        // Clear redis cache
    }
}

```

The example above guards the action controller. This means whoever is trying to access the `/cache/clear` endpoint must be granted `EXECUTE` on the `cache_clear` permission.

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

For example: __PUT__ `/services/{id}`.

### ADD

The `ADD` attribute exposes the HTTP __POST__ method on a collection of entities.

For example: __POST__ `/services`.

### DELETE

The `DELETE` attribute exposes the HTTP __DELETE__ method on a single entity.

For example: __DELETE__ `/services/{id}`.

### EXECUTE

The `EXECUTE` attribute is abstract in nature, similarly to how the permission definition of type `generic` is abstract.

It is mostly used with permission definition of type `generic`, where the permission definition is exposing system functionality such as clearing cache, running an update, installing a module, etc.

