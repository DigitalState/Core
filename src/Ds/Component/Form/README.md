# Form

The form component provides a flexible framework to handle forms, from schema to validation and submission.

It currently supports two strategies: [Formio forms](https://form.io/#/) and [Symfony form types](https://symfony.com/doc/current/reference/forms/types.html).

## Table of Contents

- [Schema](#schema)
- [Validation](#validation)
- [Submission](#submission)

## Schema

### Default Values

The form schema supports [Resolvers](../Resolver). In other words, while configuring default values for form inputs, you may not only use **literal values**, but also **resolver paths**.

For example, if you wish to populate a form input with the user's current uuid, you may use the identity resolver path, such as `ds[identity].uuid`, as the default value. Internally, the form component will resolve `ds[identity].uuid` to `294fa591-6210-4133-a7e8-d862a587792e`.

## Validation

...

## Submission

...
