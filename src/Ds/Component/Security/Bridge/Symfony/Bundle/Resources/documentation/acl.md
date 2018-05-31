# ACL

The ACL library provides a flexible framework for defining permissions and granting access on protected resources such as database records and system functionality.

## Table of Contents

- [Synopsis](#synopsis)
- [Framework](#framework)

## Synopsis

1. Activate the acl library.
2. Create a resource.
3. Create definitions which describes how your protected resource can be accessed.
4. Protect your resource from public access.
5. Grant users access to your protected resource.

## Framework

In order to better understand the ACL framework, we will start from scratch and go through each steps required to create fully-protected resource.

This section assumes you are familiar with the Symfony framework (app kernel, configurations), the ApiPlatform framework (api resources and properties) and the Doctrine ORM library.

### 1. Activate the acl library

To begin, you will need to enable the security bundle in the Symfony app kernel:

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

```
// ...

ds_security:
    acl: true
```

### 2. Create your resource

For the purpose of this demo, we will be creating a directory listing of services. Services represents government-offered services available to its citizen. For example: "Report a Pothole", "Request a Birth Certificate", etc.

In order to create such listing, we will create a new Doctrine entity named `Service` and annotate it with ApiPlatform to expose it as a JSON-based api endpoint at `/services`:

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

3. Protect your resource from public access

Protecting a resource is fairly straight forward. Simply implementing the `Secured` interface will protect the resource:

```
<?php

// ...

use Ds\Component\Security\Model\Type\Secured;

class Service implements Secured
{
    // ...
}

```

Sending an HTTP GET request to `/services` will still return a `200 OK`, however, the response body will be an empty collection:

```
[]
```

Sending an HTTP POST request to `/services` with body:

```
{
    "title": "Report a Graffiti",
    "description": "Lorem ipsum dolor sit amet, consectetur adipiscing elit."
}
```

will now return a `403 FORBIDDEN` response.


4. Create permission definitions which describes how your protected resources can be accessed
5. Grant permissions to users





