<?php

namespace Ds\Component\Camunda\Model;

/**
 * Class Deployment
 *
 * @package Ds\Component\Camunda
 */
class Deployment implements Model
{
    use Attribute\Id;
    use Attribute\Name;
    use Attribute\Source;
    use Attribute\DeploymentTime;
    use Attribute\Files;
    use Attribute\TenantId;
}
