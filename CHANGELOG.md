# Changelog

## 0.18.0 (2020-03-03)

- Feature [Discovery] Add discovery adapters (consul, env)

## 0.17.1 (2019-07-28)

- Feature [Formio] Enable arrays for formio default values

## 0.17.0 (2019-07-14)

- Feature [Acl] Restructure acl scope
- Feature [Acl] Enable dynamic permissions related to identity business unit subscriptions
- Feature [Acl] Optimize acl compilation
- Feature [Api] Restructure acl scope

## 0.16.2 (2019-04-29)

- Feature [Query] Forward query string parameters
- Feature [Query] Make `/query` path a suffix

## 0.16.1 (2019-04-28)

- Feature [Query] Add query component

## 0.16.0 (2019-03-31)

- Feature [Filter] Add filter component

## 0.15.0 (2019-03-31)

- Feature [Apip] Upgrade apip dependency to 2.3.6
- Feature [Apip] Urls changed from dashes to underscores
- Feature [Metadata] Metadata urls changed from `/metadatas` to `/metadata`

## 0.14.0 (2018-10-29)

- Feature [Tenant] Convert tenant data to runtime-only data

## 0.13.2 (2018-10-26)

- Feature [System] Set system security encoders compatible with platform

## 0.13.0 (2018-10-17)

- Feature [Security] Add compatibility to acl property serializer for non-secured entities

## 0.12.0 (2018-10-10)

- Feature [Discovery] Add servermock integration to mock discovery endpoints
- Feature [System] Add system behat context
- Feature [Api] Synchronize api host with execution environment
- Feature [System] Synchronize api host with execution environment
- Feature [Tenant] Introduce the concept of tenant unloaders
- Feature [Encryption] Add encryption component
- Feature [Config] Add encryption to config and parameter value property
- Feature [Tenant] Add encryption to tenant data property

## 0.10.0

- Feature [Discovery] Standardize discovery service names

## 0.9.0

- Feature [Discovery] Refactor discovery component to integrate with consul service catalog
- Feature [Tenant] Enable 'write' on tenant uuid property
- Feature [Api] Further map api models
- Feature [System] Further map system models
- Feature [Discovery] Further map discovery models
- Feature [Config] Add sequence reset for fixtures
- Feature [Security] Add sequence reset for fixtures
- Feature [Metadata] Add metadata component
- Bug [Api] Fix resource path for api configs tenant loader
