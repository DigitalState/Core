# Form

The form component provides a flexible framework to handle forms, from **schema** to **validation** and **submission**.

It currently supports two strategies: [Formio forms](https://form.io/#/) and [Symfony form types](https://symfony.com/doc/current/reference/forms/types.html).

## Table of Contents

- [Form](#form)
- [Schema](#schema)
- [Validation](#validation)
- [Submission](#submission)
- [Form Composition](#form-composition)

## Form

A form is essentially a json object describing its properties, layout, inputs and validations. Forms are created via supported strategies, such as the **Formio UI** or **Symfony form type classes**. However, forms are exposed through the api under a **generic structure**.

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

https://github.com/DigitalState/Guide/blob/master/build-your-first-service.md#data-resolvers-enterprise-feature

### Translations

...
https://github.com/DigitalState/Cms/blob/develop/translations-howto.md

## Validation

...

## Submission

...


## Multiple-Form Responses

The Form component supports the ability to return multiple form schemas and data properties.  A common use case for this functionality is to return a form used for input and a form used to display read-only data: Example: A BPM User Task form that is requesting that User B "Review a submission made by another user (User A)", where the Input Form is the form used by User B, and the Read-Only Form is displaying the data that was submitted by User A.

Multiple-Form responses are returned in as a JSON body in the following style:

```json
[
    {
        "id": "pothole-report",
        "method": "POST",
        "action": "/scenarios/e049f2b4-b249-48c2-850c-64d4c4b39527/submissions",
        "type": "formio",
        "display": "form",
        "schema": [
            {
                "properties": [],
                "tags": [],
                "labelPosition": "top",
                "hideLabel": false,
                "type": "textfield",
                "conditional": {
                    "eq": "",
                    "when": null,
                    "show": ""
                },
                "validate": {
                    "customPrivate": false,
                    "custom": "",
                    "pattern": "",
                    "maxLength": "",
                    "minLength": "",
                    "required": true
                },
                "clearOnHide": true,
                "hidden": false,
                "persistent": true,
                "unique": false,
                "protected": false,
                "defaultValue": "",
                "multiple": false,
                "suffix": "",
                "prefix": "",
                "placeholder": "",
                "key": "description",
                "label": "Description",
                "inputMask": "",
                "inputType": "text",
                "tableView": true,
                "input": true
            },
            {
                "hideLabel": false,
                "type": "button",
                "theme": "primary",
                "disableOnInvalid": false,
                "action": "submit",
                "block": false,
                "rightIcon": "",
                "leftIcon": "",
                "size": "md",
                "key": "submit",
                "tableView": false,
                "label": "Submit",
                "input": true
            }
        ],
        "data": [],
        "primary": true
    },
    {
        "id": "address",
        "method": null,
        "action": null,
        "type": "formio",
        "display": "form",
        "schema": [
            {
                "input": true,
                "tableView": true,
                "inputType": "text",
                "inputMask": "",
                "label": "Country",
                "key": "country",
                "placeholder": "",
                "prefix": "",
                "suffix": "",
                "multiple": false,
                "defaultValue": "",
                "protected": false,
                "unique": false,
                "persistent": true,
                "hidden": false,
                "clearOnHide": true,
                "validate": {
                    "required": false,
                    "minLength": "",
                    "maxLength": "",
                    "pattern": "",
                    "custom": "",
                    "customPrivate": false
                },
                "conditional": {
                    "show": "",
                    "when": null,
                    "eq": ""
                },
                "type": "textfield",
                "hideLabel": false,
                "labelPosition": "top",
                "tags": [],
                "properties": {}
            },
            {
                "input": true,
                "label": "Submit",
                "tableView": false,
                "key": "submit",
                "size": "md",
                "leftIcon": "",
                "rightIcon": "",
                "block": false,
                "action": "submit",
                "disableOnInvalid": false,
                "theme": "primary",
                "type": "button",
                "hideLabel": false
            }
        ],
        "data": {
            "suffix": "Mr",
            "firstName": "Morgan",
            "lastName": "Cole",
            "address": {
                "street": "111 Wellington St",
                "city": "Ottawa",
                "province": "Ontario",
                "country": "Canada",
                "postalCode": "K1A 0A4"
            },
            "phone": "1-888-111-2222",
            "email": "morgan@individual.ds",
            "birthDate": 63676800
        },
        "primary": false
    }
]
```

In the above example an array is returned with two from objects: `pothole-report` and `address` (as indicated by the `id` property)

The returned data-model is designed as a generic solution that can fit many different use cases and scenarios that may be used by a UI or another device or system that is consuming the API.

A form object has the following properties:

1. `id`: the unique id of the form.
1. `method`: the HTTP method used to submit the form.
1. `action`: the URI to be used for submitting the form.
1. `type`: the renderer to be used for the form.  This typically indicates to the application reading the form object, which rendering engine to use to parse and render the `schema` property.
1. `display`: used as a parent rendering option to tell the rendering engine which mode to use.  (Currently only used for Form `type` "formio" to indicate if the form should be rendered as a single page or wizard form.)
1. `schema`: the JSON schema of the form.
1. `data`: JSON data used by a form renderer to pre-populate form fields.  This field is most commonly used for forms that have a `primary: false` property value;
1. `primary`: indicates whether the form is the primary form in the collection of forms returned.  Primary generally indicates that the form is the "input" form which will be used for a submission.  Forms with `primary:false` typically do not have values for `method` and `action` properties.


### Creating Multi-Form Responses with Formio

In Formio form builder, in order to tell the DigitalState to return a Multi-Form respoonse, we need to configure the form with a Hidden Field:

1. Add a `hidden` component (located in the Special Components menu) anywhere in the form.  Best practice is to add the field as the very first/top or very last/bottom position on the form (single page or wizard).
1. In the API tab of the `hidden` component, select "custom properties", and set the following:
    1. **Key:** `ds_form`  **value:** `formio:address`.  Where `address` is the unique id of the form.  The value of ds_form will fetch the form and return it as a Form Object with the `primary: false` property value.
1. In the Data tab, set the Default Value field to `ds[identity].persona.data`.  Where the value of the Default Value field is a [Data Resolver](https://github.com/DigitalState/Guide/blob/master/build-your-first-service.md#data-resolvers-enterprise-feature
).  The data resolver will populate the `data` property in the form object.

You can add multiple hidden fields, which will return multiple forms in the form object.

Take into consideration form loading time: for each non-input form that is added through hidden fields, the form must be fetched, added to the response, and any data resolvers in the form need to be resolved.  If you have complex forms or are loading many forms with multiple data resolvers, the response time can exponentially increase.