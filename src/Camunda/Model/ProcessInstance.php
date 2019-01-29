<?php

namespace Ds\Component\Camunda\Model;

/**
 * Class ProcessInstance
 *
 * @package Ds\Component\Camunda
 */
final class ProcessInstance implements Model
{
    use Attribute\Id;
    use Attribute\DefinitionId;
    use Attribute\BusinessKey;
    use Attribute\CaseInstanceId;
    use Attribute\Ended;
    use Attribute\Suspended;
    use Attribute\TenantId;
    use Attribute\Links;
    use Attribute\Variables;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->links = [];
        $this->variables = [];
    }
}
