<?php

namespace Ds\Component\Camunda\Model;

use stdClass;

/**
 * Class Task
 *
 * @package Ds\Component\Camunda
 */
final class Task implements Model
{
    use Attribute\Id;
    use Attribute\Name;
    use Attribute\Assignee;
    use Attribute\Created;
    use Attribute\Due;
    use Attribute\FollowUp;
    use Attribute\DelegationState;
    use Attribute\Description;
    use Attribute\ExecutionId;
    use Attribute\Owner;
    use Attribute\ParentTaskId;
    use Attribute\Priority;
    use Attribute\ProcessDefinitionId;
    use Attribute\ProcessInstanceId;
    use Attribute\CaseExecutionId;
    use Attribute\CaseDefinitionId;
    use Attribute\CaseInstanceId;
    use Attribute\TaskDefinitionKey;
    use Attribute\FormKey;
    use Attribute\TenantId;
    use Attribute\Variables;
    use Attribute\CandidateGroup;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->variables = new stdClass;
    }
}
