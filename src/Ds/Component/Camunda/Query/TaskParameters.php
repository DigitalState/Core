<?php

namespace Ds\Component\Camunda\Query;

/**
 * Class TaskParameters
 *
 * @package Ds\Component\Camunda
 */
class TaskParameters extends AbstractParameters
{
    use Attribute\CandidateGroup;
    use Attribute\IncludeAssignedTasks;
}
