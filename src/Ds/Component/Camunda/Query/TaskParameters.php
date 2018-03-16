<?php

namespace Ds\Component\Camunda\Query;

/**
 * Class TaskParameters
 *
 * @package Ds\Component\Camunda
 */
class TaskParameters extends AbstractParameters
{
    use Attribute\Assignee;
    use Attribute\AssigneeLike;
    use Attribute\CandidateGroup;
    use Attribute\IncludeAssignedTasks;
    use Attribute\SortBy;
    use Attribute\SortOrder;
    use Attribute\FirstResult;
    use Attribute\MaxResults;
}
