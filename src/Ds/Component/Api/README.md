# Api

The api component provides a flexible framework to define and map models to microservice api endpoints. It enables the developer to work with php objects and functions instead of raw curl requests.

This component comes by default with model mappings of all DigitalState microservice apis, which includes: [Assets](https://github.com/DigitalState/Assets), [Authentication](https://github.com/DigitalState/Authentication), [Camunda](https://github.com/DigitalState/Camunda), [Cases](https://github.com/DigitalState/Cases), [Cms](https://github.com/DigitalState/Cms), [Formio](https://github.com/DigitalState/Formio), [Identities](https://github.com/DigitalState/Identities), [Records](https://github.com/DigitalState/Records), [Services](https://github.com/DigitalState/Services) and [Tasks](https://github.com/DigitalState/Tasks).

## Table of Contents

- [Architecture](#architecture)
- [Usage](#usage)

## Architecture

The component architecture consists of 3 basic elements: [Model](#model), [QueryParameters](#queryparameters) and [Service](#service).

### Model

The model classes are simple value objects that represent microservice resources, such as entities. 

For example, the [Individual](https://github.com/DigitalState/Core/blob/develop/src/Ds/Component/Api/Model/Individual.php) model, which maps to the identities/individuals endpoint:

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

The query parameters classes are simple value objects that represent metadata about the request. This typically includes search filters, ordering, pagination, etc.

For example, the [IndividualQueryParameters](https://github.com/DigitalState/Core/blob/develop/src/Ds/Component/Api/Query/IndividualParameters.php) query parameters.

```php
class IndividualParameters extends AbstractParameters
{
}
```

### Service

The service classes are objects that defines the methods to interact with microservices.

For example: the [IndividualService](https://github.com/DigitalState/Core/blob/develop/src/Ds/Component/Api/Service/IndividualService.php) service.

```php
class IndividualService extends AbstractService
{
    public function getList(Parameters $parameters = null) {}
    public function get($id, Parameters $parameters = null) {}
    public function create(Individual $individual, Parameters $parameters = null) {}
}
```

## Usage

DigitalState itself makes use of the api component internally when one microservice needs to communicate with another microservice. For example, when a user registers on the Authentication microservice, the registration scripts creates a new individual on the Identities microservice.

The developer can also create script which interacts with microservices. Below is an example of a web controller that interacts with the [Identities microservice](https://github.com/DigitalState/Identities):

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

