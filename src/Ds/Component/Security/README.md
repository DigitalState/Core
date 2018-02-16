# Security

The security component provides a flexible framework to configure access control to protect data integrity and privacy.

## Table of Contents

- [Synopsis](#synopsis)
- [Permissions](#permissions)

## Synopsis

1. Permissions define what can occur within a system.
2. Users are granted permissions.
3. When a user does an action, the system grants or denies access based on permissions.

## Permissions

Permissions describes very specific actions that can occur within the system. Whether it is **browsing** a list of cases, **editing** a case, or **deleting** a case, all actions are protected by permissions.

The permissions model provides a flexible way to define possible actions within a system and has two main values: **type** and **attributes**. 

### Types

Permission types describe the kind of access.

- **Entity**: This type of permission controls access to a database record.
- **Property**: This type of permission controls access to a database record column.
- **Generic**: This type of permission controls access to something generic.

### Attributes

Permission attributes describe the actions possible towards the type.

- **BROWSE**: Allows a user to browse a list of records.
- **READ**: Allows a user to view a record.
- **EDIT**: Allows a user to modify a record.
- **ADD**: Allows a user to add a record.
- **DELETE**: Allows a user to delete a record.
- **EXECUTE**: Allows a user to execute something.

For example, we could create a permissions configuration file with the following:

```
case:            { attributes: [BROWSE, READ, EDIT, ADD, DELETE], entity:   AppBundle\Entity\Case           }
case_title:      { attributes: [BROWSE, READ, EDIT],              property: AppBundle\Entity\Case.title     }
case_created_at: { attributes: [BROWSE, READ, EDIT],              property: AppBundle\Entity\Case.createdAt }
case_purge:      { attributes: [EXECUTE],                         generic:  CasePurge                       }
```

The first permission definition is named `case` and defines access to the Case entity. The possible actions are `BROWSE`, `READ`, `EDIT`, `ADD` and `DELETE`. 

The second permission definition is named `case_title` and defines access to the Case records title column. The possible actions are `BROWSE`, `READ` and `EDIT`.

