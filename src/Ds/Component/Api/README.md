# Api

The api component provides a flexible framework to define and map models to microservice apis. It enables the developer to work with php objects and functions instead of raw curl requests.

This component comes by default with model mappings for all DigitalState microservice apis, which includes: [Assets](https://github.com/DigitalState/Assets), [Authentication](https://github.com/DigitalState/Authentication), [Camunda](https://github.com/DigitalState/Camunda), [Cases](https://github.com/DigitalState/Cases), [Cms](https://github.com/DigitalState/Cms), [Formio](https://github.com/DigitalState/Formio), [Identities](https://github.com/DigitalState/Identities), [Records](https://github.com/DigitalState/Records), [Services](https://github.com/DigitalState/Services) and [Tasks](https://github.com/DigitalState/Tasks).

## Table of Contents

- [Architecture](#architecture)

## Architecture

The framework architecture comes with 3 basic class types: [Model](#model), [QueryParameter](#query-parameter) and [Service](#service).

### Model

The model classes are simple value objects that represent microservice resources. 

For example, the [Individual](https://github.com/DigitalState/Core/blob/develop/src/Ds/Component/Api/Model/Individual.php) model.

```php
class Individual implements Model
{
    use Attribute\Id;
    use Attribute\Uuid;
    use Attribute\CreatedAt;
    use Attribute\UpdatedAt;
    use Attribute\Owner;
    use Attribute\OwnerUuid;
    use Attribute\Version;
}
```

### QueryParameter

The query parameter classes are simple value objects that represent metadata about the request. This typically includes metadata such as search filters, ordering filters, pagination values, etc.

For example, the [IndividualQueryParameter](https://github.com/DigitalState/Core/blob/develop/src/Ds/Component/Api/Query/IndividualParameters.php) query parameter.

```php
class IndividualParameters extends AbstractParameters
{
}
```

### Service

The service classes are objects that contains the mapping information between a model and a microservice api endpoint and methods to interact with said microservice.

For example: the [IndividualService](https://github.com/DigitalState/Core/blob/develop/src/Ds/Component/Api/Service/IndividualService.php) service.

```php
class IndividualService extends AbstractService
{
    public function getList(Parameters $parameters = null) {}
    public function get($id, Parameters $parameters = null) {}
    public function create(Individual $individual, Parameters $parameters = null) {}
}
```
