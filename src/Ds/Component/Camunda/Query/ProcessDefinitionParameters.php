<?php

namespace Ds\Component\Camunda\Query;

/**
 * Class ProcessDefinitionParameters
 *
 * @package Ds\Component\Camunda
 */
class ProcessDefinitionParameters extends AbstractParameters
{
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
