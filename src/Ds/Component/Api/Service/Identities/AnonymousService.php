<?php

namespace Ds\Component\Api\Service\Identities;

use Ds\Component\Api\Model\Identities\Anonymous;
use Ds\Component\Api\Query\Identities\AnonymousParameters as Parameters;
use Ds\Component\Api\Service\AbstractService;

/**
 * Class AnonymousService
 *
 * @package Ds\Component\Api
 */
class AnonymousService extends AbstractService
{
    /**
     * @const string
     */
    const MODEL = Anonymous::class;

    /**
     * @const string
     */
    const RESOURCE_LIST = '/anonymouses';
    const RESOURCE_OBJECT = '/anonymouses/{id}';

    /**
     * @var array
     */
    protected static $map = [
        'id',
        'uuid'
    ];

    /**
     * Get anonymous list
     *
     * @param \Ds\Component\Api\Query\Identities\AnonymousParameters $parameters
     * @return array
     */
    public function getList(Parameters $parameters = null)
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
