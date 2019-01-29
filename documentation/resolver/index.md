# Resolver

The resolver component provides a flexible framework to define data resolvers and inject them in the chain of data resolvers.

## Table of Contents

- [Dependencies](#dependencies)
- [Resolvers](#resolvers)

## Dependencies

## Resolvers

...

### Api Resolver

The api-based resolver... It takes a dot-notation path and resolves it to the value in storage. It uses the api component as its data provider.

#### Template

```
ds.service.resource(parameters).property
+     +       +         +          +
|     |       |         |          |
|     |       |         |          +--> The property of the resource.
|     |       |         |
|     |       |         +--> The search filters.
|     |       |
|     |       +--> The resource name.
|     |
|     +--> The micro-service name.
|
+--> The Digitalstate namespace.
```

#### Examples

`ds.assets.asset(b8ea833f-fd9a-44f4-9c22-c1db41ae8e21).title[en]` resolves to `Library Card`

`ds.authentication.user(5b65eef8-cbc6-4492-b9d6-96077647be25).username` resolves to `morgan@individual.ds`

`ds.cases.case(c8579253-bf7d-4167-80b6-0feecc7cdb8f).priority` resolves to `2`

`ds.cms.file(d71b82fa-aa41-4c81-943c-8a07f1a61530).title[en]` resolves to `Morgan's Photo`

`ds.identities.individual(0e3fdc0e-bf6e-4be5-a5d5-d251fd408281).created_at` resolves to `2001-01-01 12:00:00`

`ds.records.record(bc267eee-7efe-4621-9c2e-8e63b6a711d6).title[en]` resolves to `Form Submission`

`ds.services.scenario(b1d81f34-68f4-44ab-8f8c-07e0eb263cf3).title[en]` resolves to `Report a Pothole`

`ds.tasks.task(6e059b83-63b6-4b6a-9e8b-86817e8c15a7).due_at` resolves to `2001-01-01 12:00:00`

### Identity Resolver

The identity-based resolver is used to resolve data based on the current logged in user. It takes a dot-notation path and resolves it to the value in session. It uses the jwt token as its data provider.

#### Template

```
ds[identity].property
+      +        +
|      |        |
|      |        +--> The property of the resource.
|      |
|      +--> The identity context.
|
+--> The Digitalstate namespace.
```

#### Examples

`ds[identity].uuid` resolves to `18ab031c-ed20-4667-9fc7-7b6af6c66d36`

`ds[identity].username` resolves to `morgan@individual.ds`

### Bpm Resolver

The bpm-based resolver is used to resolve data based on the current bpm context. It takes a dot-notation path and resolves it to the value from the bpm engine. It uses the current active workflow as its data provider.

#### Template

```
ds[bpm].resource.property
+   +      +        +
|   |      |        |
|   |      |        +--> The property of the resource.
|   |      |
|   |      +--> The resource name.
|   |
|   +--> The bpm context.
|
+--> The Digitalstate namespace.
```

#### Examples

`ds[bpm].task.variable.start_data.description` resolves to `A big pothole at ...`
