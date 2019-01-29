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

    use Attribute\Assignee;
    use Attribute\AssigneeLike;
    use Attribute\CandidateGroup;
    use Attribute\IncludeAssignedTasks;
    use Attribute\TenantIdIn;
    use Attribute\SortBy;
    use Attribute\SortOrder;
    use Attribute\FirstResult;
    use Attribute\MaxResults;
}
