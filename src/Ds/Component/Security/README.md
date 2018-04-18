# Security

The security component provides a flexible framework to define acl in order to protect data and system functionality.

It features object and field level acl, powerful permission scope granting and is compatible with the symfony security layer.

It focuses on a decentralized approach, meaning each microservice is in charge of its own acl.

## Table of Contents

- [Architecture](#architecture)
- [Usage](#usage)

## Architecture

The general architecture consists of two important elements: 

1. [Definitions](#definitions), which helps define what is protected in the system.
2. [Access Cards](#access-cards), which are assigned to users and grants them access to specific records or system functionality that are protected.

### Definitions

Definitions are found in yml configurations and are defined by the developer. They do not grant access to data or system functionality, but simply describes what and how they are protecting the subject.

A definition has a `name`, `attributes`, `type`, and `value`.

##### Name

The name consists of a unique machine name containing alphanumeric characters and underscores.

##### Attributes

The attributes consists of a list of available actions towards the protected subject. The possible values are:

- **BROWSE**: Browse a list of records.
- **READ**: View a record.
- **EDIT**: Modify an existing record.
- **ADD**: Add a new record.
- **DELETE**: Delete an existing record.
- **EXECUTE**: Execute something arbitrary.

##### Type

The type describes what kind of subject it is protecting. The possible values are:

- **Generic**: Controls access to something arbitrary.
- **Entity**: Controls access to an entity (database record).
- **Property**: Controls access to an entity property (database record column).

##### Value

The value describes the subject and is based on the type.

### Access Cards

Access cards are found in the database and are defined by administrators.

An access card has an assignee and a list of permissions that its granting.

## Usage

In this section, we will give a usage example for each definition types: [Generic](#generic), [Entity](#entity) and [Property](#property).

Consider the scenario below:

- There is an entity class found at `AppBundle\Entity\Individual`, with the following properties: `uuid` and `createdAt`.
- There is a CRUD api endpoint exposing the entity.
- There is a Redis server caching database records.
- There is an api endpoint exposing a clear-cache system functionality.

### Generic

In order to setup a protection barrier against the clear-cache endpoint, we would create a generic-typed definition.

```yml
cache_clear: { attributes: [EXECUTE], type: generic, value: CacheClear }
```

```php
class CacheController
{
    /**
     * @Security("is_granted('EXECUTE', 'cache_clear')")
     */
    public function clearAction()
    {
        $this->>redis->clear();
    }
}
```

### Entity

In order to setup a protection barrier against the Individual entity endpoint, we would create a entity-typed definition.

```yml
individual: { attributes: [BROWSE,READ,EDIT,ADD,DELETE], type: entity, value: AppBundle\Entity\Individual }
```

### Property

In order to setup a protection barrier against the Individual entity properties, we would create property-typed definitions.

```yml
individual_uuid:       { attributes: [BROWSE,READ,EDIT,ADD,DELETE], type: property, value: AppBundle\Entity\Individual.uuid }
individual_created_at: { attributes: [BROWSE,READ,EDIT,ADD,DELETE], type: property, value: AppBundle\Entity\Individual.createdAt }
```

