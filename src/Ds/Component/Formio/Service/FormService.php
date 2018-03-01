<?php

namespace Ds\Component\Formio\Service;

use Ds\Component\Formio\Model\Form;
use Ds\Component\Formio\Query\FormParameters as Parameters;
use stdClass;
use DateTime;

/**
 * Class FormService
 *
 * @package Ds\Component\Formio
 */
class FormService extends AbstractService
{
    /**
     * @const string
     */
    const MODEL = Form::class;

    /**
     * @const string
     */
    const RESOURCE_LIST = '/form';
    const RESOURCE_OBJECT = '/form/{id}';
    const RESOURCE_OBJECT_BY_PATH = '/{path}';

    /**
     * @var array
     */
    protected static $map = [
        'id' => '_id',
        'updated' => 'modified',
        'created',
        'title',
        'display',
        'type',
        'name',
        'path',
        'components',
        'tags',
        'access',
        'owner'
    ];

    /**
     * Get form list
     *
     * @param \Ds\Component\Formio\Query\FormParameters $parameters
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

    /**
     * Get form
     *
     * @param string $id
     * @param \Ds\Component\Formio\Query\FormParameters $parameters
     * @return \Ds\Component\Formio\Model\Form
     */
    public function get($id, Parameters $parameters = null)
    {
        if (null !== $id) {
            $resource = str_replace('{id}', $id, static::RESOURCE_OBJECT);
        } else {
            $resource = str_replace('{path}', $parameters->getPath(), static::RESOURCE_OBJECT_BY_PATH);
        }

        $options = [
            'headers' => [
                'Accept' => 'application/json'
            ]
        ];

        $object = $this->execute('GET', $resource, $options);
        $model = static::toModel($object);

        return $model;
    }

    /**
     * Create form
     *
     * @param \Ds\Component\Formio\Model\Form $form
     * @param \Ds\Component\Formio\Query\FormParameters $parameters
     * @return \Ds\Component\Formio\Model\Form
     */
    public function create(Form $form, Parameters $parameters = null)
    {
        $options = [
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ],
            'json' => [
                'title' => $form->getTitle(),
                'display' => $form->getDisplay(),
                'type' => $form->getType(),
                'name' => $form->getName(),
                'path' => $form->getPath(),
                'tags' => $form->getTags(),
                'components' => $form->getComponents()
            ]
        ];

        $object = $this->execute('POST', static::RESOURCE_LIST, $options);
        $model = static::toModel($object);

        return $model;
    }

    /**
     * Delete form
     *
     * @param string $path
     * @param \Ds\Component\Formio\Query\FormParameters $parameters
     */
    public function delete($path, Parameters $parameters = null)
    {
        $resource = str_replace('{path}', $path, static::RESOURCE_OBJECT_BY_PATH);
        $this->execute('DELETE', $resource);
    }
}
