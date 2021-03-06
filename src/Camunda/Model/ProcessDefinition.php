<?php

namespace Ds\Component\Camunda\Model;

/**
 * Class ProcessDefinition
 *
 * @package Ds\Component\Camunda
 */
final class ProcessDefinition implements Model
{
    use Attribute\Id;
    use Attribute\Key;
    use Attribute\Name;
    use Attribute\Description;
    use Attribute\Category;
    use Attribute\Resource;
    use Attribute\DeploymentId;
    use Attribute\Diagram;
    use Attribute\TenantId;
    use Attribute\Version;
    use Attribute\VersionTag;
}
