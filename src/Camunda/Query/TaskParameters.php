<?php

namespace Ds\Component\Camunda\Query;

/**
 * Class TaskParameters
 *
 * @package Ds\Component\Camunda
 */
final class TaskParameters implements Parameters
{
    use Base;

    use Attribute\TaskIdIn;
    use Attribute\Assignee;
    use Attribute\AssigneeLike;
    use Attribute\CandidateGroups;
    use Attribute\IncludeAssignedTasks;
    use Attribute\CreatedBefore;
    use Attribute\CreatedAfter;
    use Attribute\DueBefore;
    use Attribute\DueAfter;
    use Attribute\Priority;
    use Attribute\TenantIdIn;
    use Attribute\SortBy;
    use Attribute\SortOrder;
    use Attribute\FirstResult;
    use Attribute\MaxResults;
}
