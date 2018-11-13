<?php

namespace Ds\Component\Api\Service;

use Ds\Component\Api\Model\Submission;
use Ds\Component\Api\Query\SubmissionParameters as Parameters;

/**
 * Class SubmissionService
 *
 * @package Ds\Component\Api
 */
final class SubmissionService implements Service
{
    use Base;

    /**
     * @const string
     */
    const MODEL = Submission::class;

    /**
     * @const string
     */
    const RESOURCE_LIST = '/submissions';
    const RESOURCE_OBJECT = '/submissions/{id}';

    /**
     * @var array
     */
    private static $map = [
        'id',
        'uuid'
    ];

    /**
     * Get submission list
     *
     * @param \Ds\Component\Api\Query\SubmissionParameters $parameters
     * @return array
     */
    public function getList(Parameters $parameters = null): array
    {
        $objects = $this->execute('GET', 'http://www.mocky.io/v2/592b798d100000b10e389778');
        $list = [];

        foreach ($objects as $object) {
            $model = static::toModel($object);
            $list[] = $model;
        }

        return $list;
    }
}
