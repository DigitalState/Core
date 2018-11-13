<?php

namespace Ds\Component\Camunda\Query;

/**
 * Class DeploymentParameters
 *
 * @package Ds\Component\Camunda
 */
final class DeploymentParameters implements Parameters
{
    use Base;

    use Attribute\Cascade;
    use Attribute\Source;
}
