<?php

namespace Ds\Component\Camunda\Query;

/**
 * Class ProcessDefinitionParameters
 *
 * @package Ds\Component\Camunda
 */
final class ProcessDefinitionParameters implements Parameters
{
    use Base;

    use Attribute\Name;
    use Attribute\Key;
    use Attribute\TenantId;
    use Attribute\Variables;
    use Attribute\WithVariablesInReturn;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->variables = [];
    }
}
