<?php

namespace Ds\Component\Camunda\Service\Task;

use Ds\Component\Camunda\Service\VariableService as BaseVariableService;

/**
 * Class VariableService
 *
 * @package Ds\Component\Camunda
 */
final class VariableService extends BaseVariableService
{
    /**
     * @const string
     */
    const VARIABLE_LIST = '/task/{id}/variables';
}
