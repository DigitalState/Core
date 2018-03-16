# Form

The form component provides a flexible framework to handle forms, from **schema** to **validation** and **submission**.

It currently supports two strategies: [Formio forms](https://form.io/#/) and [Symfony form types](https://symfony.com/doc/current/reference/forms/types.html).

## Table of Contents

- [Form](#form)
- [Schema](#schema)
- [Validation](#validation)
- [Submission](#submission)

## Form

A form is essentially a json object describing its properties, layout, inputs and validations. Forms are created via supported strategies, such as the Formio UI or Symfony form type classes. However, forms are exposed through the api under a generic structure.

Here is a simplified form example:

```
{
    "id": "pothole-report",
    "method": "POST",
    "action": "/scenarios/e049f2b4-b249-48c2-850c-64d4c4b39527/submissions",
    "type": "formio",
    "display": "form",
    "schema": [
        {
            "type": "textfield",
            "key": "description",
            "label": "Description",
            "defaultValue": "Description of pothole here..."
        },
        {
            "type": "button",
            "key": "submit",
            "label": "Submit"
        }
    ]
}
```

## Schema

...

### Default Values

The form component supports [Resolvers](../Resolver). In other words, while configuring default values for form inputs, you may use **resolver paths** instead of **literal values**.

For example, imagine we want to use the **current logged in user's uuid** as a default value for a form input, you may use the resolver path `ds[identity].uuid` as the default value. Internally, the form component will resolve `ds[identity].uuid` to `294fa591-6210-4133-a7e8-d862a587792e` prior to returning the form object.

### Translations

...

## Validation

...

## Submission

...
