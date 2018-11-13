<?php

namespace Ds\Component\Formio\Service;

use Ds\Component\Formio\Model\Project;

/**
 * Class ProjectService
 *
 * @package Ds\Component\Formio
 */
final class ProjectService implements Service
{
    use Base;

    /**
     * @const string
     */
    const MODEL = Project::class;

    /**
     * @var array
     */
    private static $map = [
        'id' => '_id',
        'updated' => 'modified',
        'title'
    ];
}
