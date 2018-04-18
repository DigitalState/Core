# Api

The api component provides a flexible framework to define and map models to microservice apis. It enables the developer to work with php objects and functions instead of raw curl requests.

This component comes by default with model mappings for all DigitalState microservice apis, which includes: [Assets](https://github.com/DigitalState/Assets), [Authentication](https://github.com/DigitalState/Authentication), [Camunda](https://github.com/DigitalState/Camunda), [Cases](https://github.com/DigitalState/Cases), [Cms](https://github.com/DigitalState/Cms), [Formio](https://github.com/DigitalState/Formio), [Identities](https://github.com/DigitalState/Identities), [Records](https://github.com/DigitalState/Records), [Services](https://github.com/DigitalState/Services) and [Tasks](https://github.com/DigitalState/Tasks).

## Table of Contents

- [Architecture](#architecture)
- [Usage](#usage)

## Architecture

The framework architecture comes with 3 basic class types: [Model](#model), [QueryParameters](#queryparameters) and [Service](#service).

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

### QueryParameters

The query parameters classes are simple value objects that represent metadata about the request. This typically includes metadata such as search filters, ordering filters, pagination values, etc.

For example, the [IndividualQueryParameters](https://github.com/DigitalState/Core/blob/develop/src/Ds/Component/Api/Query/IndividualParameters.php) query parameters.

```php
class IndividualParameters extends AbstractParameters
{
}
```

### Service

The service classes are objects that contains methods to interact with a microservice. It also has the mapping information between a model and said microservice api endpoints.

For example: the [IndividualService](https://github.com/DigitalState/Core/blob/develop/src/Ds/Component/Api/Service/IndividualService.php) service.

```php
class IndividualService extends AbstractService
{
    protected static $map = [
        'id',
        'uuid',
        'createdAt',
        'updatedAt',
        'owner',
        'ownerUuid',
        'version'
    ];
    
    public function getList(Parameters $parameters = null) {}
    public function get($id, Parameters $parameters = null) {}
    public function create(Individual $individual, Parameters $parameters = null) {}
}
```

## Usage

The example below represents a typical controller that contains 2 actions which interacts with the [Identities microservice][https://github.com/DigitalState/Identities]:

```php
class IndividualController
{
    public function indexAction()
    {
        $api = $this->container->get('ds_api.api');
        $service = $api->get('identities.individual');
        $individuals = $service->getList();
        
        foreach ($individuals as $individual) {
            print_r($individual);
        }
    }
    
    public function createAction()
    {
        $api = $this->container->get('ds_api.api');
        $service = $api->get('identities.individual');
        $individual = new Individual;
        $individual
            ->setOwner('BusinessUnit')
            ->setOwnerUuid('22a3d4a5-99c4-488c-98d0-6f217068a356');
        $service->create($individual);
        print_r($individual);
    }
}
```

