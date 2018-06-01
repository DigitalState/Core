# Access Cards

The concept of access cards provide a low-level mechanism for granting users permissions within the system.

Access cards can be directly created and used on their own, or intermediately created and used by higher level permission-granting concepts such as Roles, Groups and Shares. Regardless of what is granting a particular permission to a particular user, we will always find a low-level access card responsible for granting that permission.

One major advantage of this separation of concerns is it enables all kinds of high-level concepts to grant permissions in a unidirectional fashion understood by the ACL framework.

## Table of Contents

- [Implementation](#implementation)
- [Assignee](#assignee)
- [Permissions](#permissions)

# Implementation

Access cards are stored in the database and mapped under the [`Access`](https://github.com/DigitalState/Core/blob/develop/src/Ds/Component/Security/Entity/Access.php) and [`Permissions`](https://github.com/DigitalState/Core/blob/develop/src/Ds/Component/Security/Entity/Permission.php) Doctrine entities provided by the [Security bundle](https://github.com/DigitalState/Core/tree/develop/src/Ds/Component/Security).

The `Access` entity contains an assignee and a collection of `Permissions` entities.

Below is a real world example found within the [Services Microservice](https://github.com/DigitalState/Services) sample data of the [DigitalState Platform](https://github.com/DigitalState/Platform):

```
{
    // ...
    "uuid": "e7c14666-e442-4097-b0b7-0c8f2647c988",
    "assignee": "Role",
    "assigneeUuid": "3e64bbd1-4d00-47e7-a35e-92691f5a6018",
    "permissions": [
        {
            "scope": "owner",
            "entity": "BusinessUnit",
            "entityUuid": "a9d68bf7-5000-49fe-8b00-33dde235b327",
            "key": "service",
            "attributes": ["BROWSE", "READ"]
        },
        {
            "scope": "owner",
            "entity": "BusinessUnit",
            "entityUuid": "a9d68bf7-5000-49fe-8b00-33dde235b327",
            "key": "service_property",
            "attributes": ["BROWSE", "READ"]
        },
        // ...
    ]
}
```

Without going into too much details yet, the example above demonstrates the access card responsible for granting specific permissions to all users who have the Role `3e64bbd1-4d00-47e7-a35e-92691f5a6018` (Staff Role). It grants `BROWSE` and `READ` access to all `Service` entities found in the database that are owned by the business unit `a9d68bf7-5000-49fe-8b00-33dde235b327` (Backoffice).

## Assignee

The assignee refers to what is inheriting the granted permissions within this access card. The assignee may contain a user, a role, etc.

Users may inherit __zero__, __one__ or __multiple__ access cards through direct assignment or indirect assignment, such as a Role. Access cards are compiled early on in the execution of the request based on the user information found in the JWT token. The compiled access cards are subsequently used to validate authorization.

Below are examples of various types of assignment.

An access card directly assigned to a staff member:

```
{
    // ...
    "assignee": "Staff",
    "assigneeUuid": "80eec32f-dbd6-4789-8991-d60dfe684192",
    "permissions": [
        // ...
    ]
}
```

An access card indirectly assigned to a staff member via a role:

```
{
    // ...
    "assignee": "Role",
    "assigneeUuid": "3e64bbd1-4d00-47e7-a35e-92691f5a6018",
    "permissions": [
        // ...
    ]
}
```

## Permissions

The collection of permissions found within an access card represents granted permissions against [definitions](permissions.md), including which [attributes](permissions.md#attributes) are being granted.

Each permissions contains a `key`, `attributes`scope`, a `scope` and are described below.

### Key

The permission key value contains the key name of a configured permission definition. More can be read on permission definition [here](permissions.md).

### Attributes

The permission attributes value contains an array of actions granted. The possible values are `BROWSE`, `READ`, `EDIT`, `ADD`, `DELETE` and `EXECUTE`. More can be read on attributes [here](permissions.md#attributes).

### Scope

The permission scope further helps control and refine the way we are granting access towards a configured permission definition. The possible values are `generic`, `object`, `owner`, `identity` and `session`.

#### Generic Scope

The `generic` scope grants carte-blanche on the given permission definition.

In the example below, whoever is inheriting this access card can `READ` all `Service` entities.

```
{
    // ...
    "assignee": "Role",
    "assigneeUuid": "3e64bbd1-4d00-47e7-a35e-92691f5a6018",
    "permissions": [
        {
            "scope": "generic",
            "entity": null,
            "entityUuid": null,
            "key": "service",
            "attributes": ["READ"]
        },
        // ...
    ]
}
```

#### Object Scope

The `object` scope only grants access on a very specific object referenced by uuid.

This scope is typically used when a user wishes to share a single, specific object with another user.

In the example below, whoever is inheriting this access card can `READ` the `Service` entity with uuid `ce649cc8-c283-4e4a-af30-9e5de4e9686d`.

```
{
    // ...
    "assignee": "Role",
    "assigneeUuid": "3e64bbd1-4d00-47e7-a35e-92691f5a6018",
    "permissions": [
        {
            "scope": "object",
            "entity": null,
            "entityUuid": "ce649cc8-c283-4e4a-af30-9e5de4e9686d",
            "key": "service",
            "attributes": ["READ"]
        },
        // ...
    ]
}
```

#### Owner Scope

The `owner` scope grants access on a subset of entries based on the owner of such entries.

This scope is typically used the most and often contains a business unit as a owner.

In the example below, whoever is inheriting this access card can `READ` the `Service` entities owned by the business unit `a9d68bf7-5000-49fe-8b00-33dde235b327`.

```
{
    // ...
    "assignee": "Role",
    "assigneeUuid": "3e64bbd1-4d00-47e7-a35e-92691f5a6018",
    "permissions": [
        {
            "scope": "owner",
            "entity": "BusinessUnit",
            "entityUuid": "a9d68bf7-5000-49fe-8b00-33dde235b327",
            "key": "service",
            "attributes": ["READ"]
        },
        // ...
    ]
}
```

#### Identity Scope

The `identity` scope grants access on a subset of entries based on the identity of such entries.

This scope is sometimes when a user needs to see another users data and typically contains an Individual or Organization as the identity.

In the example below, whoever is inheriting this access card can `READ` the `Case` entities opened by Individual `33bdd8a3-7652-4b64-afdd-658b330ac71b`.

```
{
    // ...
    "assignee": "Role",
    "assigneeUuid": "3e64bbd1-4d00-47e7-a35e-92691f5a6018",
    "permissions": [
        {
            "scope": "identity",
            "entity": "Individual",
            "entityUuid": "33bdd8a3-7652-4b64-afdd-658b330ac71b",
            "key": "case",
            "attributes": ["READ"]
        },
        // ...
    ]
}
```

#### Session Scope

The `session` scope grants access on a subset of entries based on the current logged in user.

This scope is similar to the `identity` scope, except it uses the identity value found in the user session, instead of it being explicitly defined in the database.

In the example below, whoever is inheriting this access card can `READ` the `Case` entities opened by itself.

```
{
    // ...
    "assignee": "Role",
    "assigneeUuid": "3e64bbd1-4d00-47e7-a35e-92691f5a6018",
    "permissions": [
        {
            "scope": "session",
            "entity": null,
            "entityUuid": null,
            "key": "case",
            "attributes": ["READ"]
        },
        // ...
    ]
}
```
