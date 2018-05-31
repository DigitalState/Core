# ACL

The ACL library provides a flexible framework for defining permissions and granting access to protected entities and system functionality.

This section assumes you are familiar with the [Symfony framework](https://symfony.com/doc/current/index.html) (app kernel, configurations), the [ApiPlatform framework](https://api-platform.com/docs/core) (api resources and properties) and the [Doctrine ORM library](https://www.doctrine-project.org/projects/doctrine-orm/en/latest/tutorials/getting-started.html).

## Table of Contents

- [Synopsis](#synopsis)
- [Overview](#overview)

## Synopsis

1. [Activate the ACL library.](#1-activate-the-acl-library)
2. [Create a Doctrine entity and expose it as a RESTful api endpoint.](#2-create-a-doctrine-entity-and-expose-it-as-a-restful-api-endpoint)
3. [Protect the entity with the ACL library.](#3-protect-the-entity-with-the-acl-library)
4. [Describe how the entity can be accessed.](#4-describe-how-the-entity-can-be-accessed)
5. [Grant users access to the protected entity.](#5-grant-users-access-to-the-protected-entity)

## Overview

In order to better understand the ACL framework, we will go through each steps required for __creating__ a new Doctrine entity, __exposing it__ as a RESTful api endpoint and fully __protecting it__ using the ACL framework.

### 1. Activate the acl library

To begin, you will need to enable the security bundle in the Symfony app kernel:

__app/AppKernel.php__

```
    // ...

    public function registerBundles()
    {
        $bundles = [
            // ...
            new Ds\Component\Security\Bridge\Symfony\Bundle\DsSecurityBundle(),
        ];

        // ...
    }

    // ...
```

Additionally, the acl library needs to be enabled in the Symfony configurations:

__app/config/config.yml__

```
// ...

ds_security:
    acl: true
```

### 2. Create a Doctrine entity and expose it as a RESTful api endpoint

For the purpose of this demo, we will be creating a directory listing of services.

Services represents government-offered services available to its citizen. For example: "Report a Pothole", "Request a Birth Certificate", etc.

In order to create such listing, we will create a new Doctrine entity named `Service` and annotate it with ApiPlatform in order to expose it as a JSON-based api endpoint at `/services`:

__src/AppBundle/Entity/Service.php__

```
<?php

namespace AppBundle\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiProperty;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource
 * @ORM\Entity
 */
class Service
{
    /**
     * @ApiProperty
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="id", type="integer")
     */
    protected $id;

    /**
     * @ApiProperty
     * @ORM\Column(name="title", type="string")
     */
    protected $title;

    /**
     * @ApiProperty
     * @ORM\Column(name="description", type="string")
     */
    protected $description;
}

```

Setting aside Symfony's firewalls configurations, the `/services` endpoint is open to the public in its current state.

Sending an HTTP __GET__ request to `/services` will return a `200 OK` response with the following body:

```
[
    {
        "id": 1,
        "title": "Report a Pothole",
        "description": "Lorem ipsum dolor sit amet, consectetur adipiscing elit."
    },
    {
        "id": 2,
        "title": "Request a Birth Certificate",
        "description": "Lorem ipsum dolor sit amet, consectetur adipiscing elit."
    }
]
```

Sending an HTTP __POST__ request to `/services` with body:

```
{
    "title": "Report a Graffiti",
    "description": "Lorem ipsum dolor sit amet, consectetur adipiscing elit."
}
```

will return a `201 CREATED` response with body:

```
{
    "id": 3,
    "title": "Report a Graffiti",
    "description": "Lorem ipsum dolor sit amet, consectetur adipiscing elit."
}
```

### 3. Protect the entity with the ACL library

Protecting an entity with the ACL library is fairly straight forward. Implementing the `Secured` interface will activate the ACL guard on the entity:

__src/AppBundle/Entity/Service.php__

```
<?php

// ...

use Ds\Component\Security\Model\Type\Secured;

class Service implements Secured
{
    // ...
}

```

The ACL library is integrated with the ApiPlatform framework through it's [event system](https://api-platform.com/docs/core/events/) and will properly guard entities from read or write access based on the granted permissions (which well talk about later).

Sending an HTTP __GET__ or __POST__ request to `/services` will now return a `403 FORBIDDEN`. This is due to the fact that no one has been granted read or write access to the `Service` entity.

### 4. Describe how the entity can be accessed

Prior to granting access to the `Service` entity to various users, the ACL library requires us to __describe how the entity can be accessed__.

For the purpose of this demo, we will define all possible permissions on the `Service` entity. Simply add the following to the Symfony configurations:

__app/config/config.yml__

```
ds_security:
    acl: true
    permissions:
        service:             { entity:   AppBundle\Entity\Service,               attributes: [BROWSE, READ, EDIT, ADD, DELETE] }
        service_id:          { property: AppBundle\Entity\Service.id,            attributes: [BROWSE, READ, EDIT] }
        service_title:       { property: AppBundle\Entity\Service.title,         attributes: [BROWSE, READ, EDIT] }
        service_description: { property: AppBundle\Entity\Service.description,   attributes: [BROWSE, READ, EDIT] }

```

Here, we are creating four new permissions, named `service`, `service_id`, `service_title` and `service_description`. These names must be unique and are later used when granting access.

- The permission named `service` is of type __entity__, meaning we are defining a permission that makes the `AppBundle\Entity\Service` entity eligible to be __browsed__, __read__, __edited__, __added__ or __deleted__.
- The permission named `service_id` is of type __property__, meaning we are defining a permission that makes the `id` property of the `AppBundle\Entity\Service` entity eligible to be __browsed__, __read__ or __edited__. The same can be said respectively for each other property-based permissions.

Internally, the ACL library integrates with the ApiPlatform framework and __maps permission attributes to HTTP request methods__. Essentially, the attribute:

- `BROWSE` maps to __GET__ `/services`
- `READ` maps to __GET__ `/services/{id}`
- `EDIT` maps to __PUT__ `/services/{id}`
- `ADD` maps to __POST__ `/services`
- `DELETE` maps to __DELETE__ `/services/{id}`

`BROWSE` and `READ` are both read-based attributes. However, they distinguish themselves based on whether we are reading a collection of entities versus a single entity. This becomes particularly useful in scenarios where some users are only granted browsing a collection and only on a few properties and not necessarily reading single entities or vice versa.

Also, if we wanted for example to completely disable Service entities from being deleted at the code-level, simply removing the `DELETE` attribute on the entity permission would completely block the __DELETE__ HTTP method.

You may want to consult the [full documentation on permissions](acl/permissions.md), which includes all the possible types and attributes and described in much more details.

### 5. Grant users access to the protected entity

Despite defining all the permissions above, the `Service` entity is still not accessible. We have only made it eligible to be accessed, through explicit channels, using a nomenclature that the ACL library understands.

The next step is granting users specific permissions through what we call __access cards__.

An access card is essentially a __collection of granted permissions__ saved in the database and is __associated with a user or role__. A user may have __zero__, __one__ or __multiple__ access cards associated with it through direct associations or via a role he belongs to.

For the purpose of this demo, we will create two access cards: one for a __Staff__ member named Alex representing an __administrator__ and one for an __Individual__ named Morgan representing a __citizen__.

__Alex__

```
{
    // ...
    "assignee": "Staff",
    "assigneeUuid": "703fb098-40df-486d-8e08-65d892b4c288", // Alex's Staff UUID
    "permissions": [
        {
            "scope": "generic",
            "key": "service",
            "attributes": ["BROWSE", "READ", "EDIT", "ADD", "DELETE"]
            // ...
        },
        {
            "scope": "generic",
            "key": "service_id",
            "attributes": ["BROWSE", "READ", "EDIT"]
            // ...
        },
        {
            "scope": "generic",
            "key": "service_title",
            "attributes": ["BROWSE", "READ", "EDIT"]
            // ...
        },
        {
            "scope": "generic",
            "key": "service_description",
            "attributes": ["BROWSE", "READ", "EDIT"]
            // ...
        }
    ]
}
```

Here, we want Alex to full access to the `Service` entity so he may manage all services. The access card above essentially grants Alex all permissions possible on the `Service` entity. Alex may browse, read, edit, add and delete services and access all properties of the `Service` entity.

__Morgan__

```
{
    // ...
    "assignee": "Individual",
    "assigneeUuid": "1106a13c-6673-401c-95df-56f2477627ab", // Morgan's Individual UUID
    "permissions": [
        {
            "scope": "generic",
            "key": "service",
            "attributes": ["BROWSE", "READ"]
            // ...
        },
        {
            "scope": "generic",
            "key": "service_title",
            "attributes": ["BROWSE", "READ"]
            // ...
        },
        {
            "scope": "generic",
            "key": "service_description",
            "attributes": ["BROWSE", "READ"]
            // ...
        }
    ]
}
```

Here, we want Morgan to have browse and read access so he may consult government services he may be interested in. The access card above essentially grants Morgan only browsing and reading permissions on the `Service` entity. Also, he only has access to the `title` and `description` properties.