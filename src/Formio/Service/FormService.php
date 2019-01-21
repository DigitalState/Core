<?php

namespace Ds\Component\Formio\Service;

use Ds\Component\Api\Service\Service;
use Ds\Component\Formio\Model\Form;
use Ds\Component\Formio\Query\FormParameters as Parameters;
use stdClass;
use DateTime;

/**
 * Class FormService
 *
 * @package Ds\Component\Formio
 */
final class FormService implements Service
{
    use Base;

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
    private static $map = [
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
        'owner',
        'submissionAccess'
    ];

    /**
     * Get form list
     *
     * @param \Ds\Component\Formio\Query\FormParameters $parameters
     * @return array
     */
    public function getList(Parameters $parameters = null): array
    {
        $objects = $this->execute('GET', static::RESOURCE_LIST);
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
    public function get(?string $id, Parameters $parameters = null): Form
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
        /** @var \Ds\Component\Formio\Model\Form $model */
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
    public function create(Form $form, Parameters $parameters = null): Form
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
                'components' => $form->getComponents(),
                'submissionAccess' => $form->getSubmissionAccess()
            ]
        ];

        $object = $this->execute('POST', static::RESOURCE_LIST, $options);
        /** @var \Ds\Component\Formio\Model\Form $model */
        $model = static::toModel($object);

        return $model;
    }

    /**
     * Update form
     *
     * @param \Ds\Component\Formio\Model\Form $form
     * @param \Ds\Component\Formio\Query\FormParameters $parameters
     * @return \Ds\Component\Formio\Model\Form
     */
    public function update(Form $form, Parameters $parameters = null): Form
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
                'components' => $form->getComponents(),
                'submissionAccess' => $form->getSubmissionAccess()
            ]
        ];

        $resource = str_replace('{path}', $form->getPath(), static::RESOURCE_OBJECT_BY_PATH);
        $object = $this->execute('PUT', $resource, $options);
        /** @var \Ds\Component\Formio\Model\Form $model */
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
