# ACL

The ACL library provides a flexible framework for defining permissions and granting access to protected entities and system functionality.

This part of the documentation assumes you are familiar with the Symfony framework (app kernel, configurations), the ApiPlatform framework (api resources and properties) and the Doctrine ORM library.

## Table of Contents

- [Synopsis](#synopsis)
- [Framework](#framework)

## Synopsis

1. Activate the ACL library.
2. Create a Doctrine entity and expose it as an api endpoint.
3. Protect your entity with the ACL library.
4. Describe how your entity can be accessed.
5. Grant users access to your protected entity.

## Framework

In order to better understand the ACL framework, we will go through each steps required for creating a new Doctrine entity, exposing it as an api endpoint and fully protecting it using the ACL framework.

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

### 2. Create a Doctrine entity and expose it as an api endpoint

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

Sending an HTTP GET request to `/services` will return a `200 OK` response with the following body:

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

Sending an HTTP POST request to `/services` with body:

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

### 3. Protect your entity with the ACL library

Protecting an entity with the ACL library is fairly straight forward. Implementing the `Secured` interface will configure the ACL guard on the entity:

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

The ACL library is integrated with the ApiPlatform framework through it's event system and will properly guard entities from read or write access based on the granted permissions.

Sending an HTTP GET request to `/services` will now return a `403 FORBIDDEN`.

Sending an HTTP POST request to `/services` with body:

```
{
    "title": "Report a Graffiti",
    "description": "Lorem ipsum dolor sit amet, consectetur adipiscing elit."
}
```

will now return a `403 FORBIDDEN` response.

This is due to the fact that no one has been granted read or write access to the Service entity.

### 4. Describe how your entity can be accessed

Prior to granting access to the Service entity, the ACL library requires us to define what and how the Service entity can be

### 5. Grant users access to your protected entity

