<?php

namespace Ds\Component\Form\Service;

use DomainException;
use Ds\Component\Api\Api\Api;
use Ds\Component\Form\Model\Form;
use Ds\Component\Formio\Query\FormParameters;
use Ds\Component\Resolver\Exception\UnmatchedException;
use Ds\Component\Resolver\Exception\UnresolvedException;
use Ds\Component\Resolver\Collection\ResolverCollection;
use Ds\Component\Tenant\Service\TenantService;
use InvalidArgumentException;

/**
 * Class FormService
 *
 * @package Ds\Component\Form
 */
final class FormService
{
    /**
     * @var \Ds\Component\Api\Api\Api
     */
    private $api;

    /**
     * @var \Ds\Component\Resolver\Collection\ResolverCollection
     */
    private $resolverCollection;

    /**
     * @var \Ds\Component\Tenant\Service\TenantService
     */
    private $tenantService;

    /**
     * Constructor
     *
     * @param \Ds\Component\Api\Api\Api $api
     * @param \Ds\Component\Resolver\Collection\ResolverCollection $resolverCollection
     * @param \Ds\Component\Tenant\Service\TenantService $tenantService
     * #param \Ds\Component\Tenant\Service\TenantService $tenantService
     */
    public function __construct(Api $api, ResolverCollection $resolverCollection, TenantService $tenantService)
    {
        $this->api = $api;
        $this->resolverCollection = $resolverCollection;
        $this->tenantService = $tenantService;
    }

    /**
     * Get form
     *
     * @param string $id
     * @return \Ds\Component\Form\Model\Form
     * @throws \InvalidArgumentException
     * @throws \DomainException
     */
    public function getForm($id)
    {
        if (!preg_match('/^([a-z]+):([-_a-z0-9]+)$/i', $id, $matches)) {
            throw new InvalidArgumentException('Form id is not valid.');
        }

        $form = new Form;
        $form
            ->setType($matches[1])
            ->setId($this->tenantService->getContext().'-'.$matches[2]);

        switch ($form->getType()) {
            case Form::TYPE_FORMIO:
                $parameters = new FormParameters;
                $parameters->setPath($form->getId());
                $formio = $this->api->get('formio.form')->get(null, $parameters);
                $form
                    ->setDisplay($formio->getDisplay())
                    ->setSchema($formio->getComponents());

                break;

            case Form::TYPE_SYMFONY:
                break;

            default:
                throw new DomainException('Form type does not exist.');
        }

        return $form;
    }

    /**
     * Get form, including subforms
     *
     * @param string $id
     * @return array
     */
    public function getForms($id)
    {
        $forms = [];
        $form = $this->getForm($id);
        $form
            ->setMethod('POST')
            ->setPrimary(true);
        $forms[] = $form;

        switch ($form->getType()) {
            case Form::TYPE_FORMIO:
                $components = $form->getSchema();
                $resolverCollection = $this->resolverCollection;
                $extract = function(&$container, $key, &$component) use (&$extract, &$forms, $resolverCollection) {
                    switch (true) {
                        case property_exists($component, 'components'):
                            foreach ($component->components as $key => &$subComponent) {
                                $extract($component->components, $key, $subComponent);
                            }

                            break;

                        case property_exists($component, 'columns'):
                            foreach ($component->columns as &$column) {
                                foreach ($column->components as $key => &$subComponent) {
                                    $extract($column->components, $key, $subComponent);
                                }
                            }

                            break;

                        case property_exists($component, 'properties')
                            && is_object($component->properties)
                            && property_exists($component->properties, 'ds_form'):
                            $form = $this->getForm($component->properties->ds_form);
                            $data = [];

                            if (property_exists($component, 'defaultValue')) {
                                try {
                                    $data = $resolverCollection->resolve($component->defaultValue);
                                } catch (UnresolvedException $exception) {
                                    $data = [];
                                } catch (UnmatchedException $exception) {
                                    // Leave default value as-is
                                }
                            }

                            $form->setData($data);
                            $forms[] = $form;
                            unset($container[$key]);
                            break;
                    }
                };

                foreach ($components as $key => &$component) {
                    $extract($components, $key, $component);
                }

                $form->setSchema(array_values($components));

                break;

            case Form::TYPE_SYMFONY:
                break;

            default:
                throw new DomainException('Form type does not exist.');
        }

        return $forms;
    }

    /**
     * Resolve a form
     *
     * @param \Ds\Component\Form\Model\Form $form
     * @return \Ds\Component\Form\Model\Form
     */
    public function resolve(Form $form)
    {
        switch ($form->getType()) {
            case Form::TYPE_FORMIO:
                $components = $form->getSchema();
                $resolverCollection = $this->resolverCollection;
                $resolve = function(&$component) use (&$resolve, $resolverCollection) {
                    switch (true) {
                        case property_exists($component, 'components'):
                            foreach ($component->components as &$subComponent) {
                                $resolve($subComponent);
                            }

                            break;

                        case property_exists($component, 'columns'):
                            foreach ($component->columns as &$column) {
                                foreach ($column->components as &$subComponent) {
                                    $resolve($subComponent);
                                }
                            }

                            break;

                        case property_exists($component, 'defaultValue'):
                            try {
                                $component->defaultValue = $resolverCollection->resolve($component->defaultValue);
                            } catch (UnresolvedException $exception) {
                                $component->defaultValue = null;
                            } catch (UnmatchedException $exception) {
                                // Leave default value as-is
                            }

                            break;
                    }
                };

                foreach ($components as &$component) {
                    $resolve($component);
                }

                $form->setSchema($components);

                break;

            case Form::TYPE_SYMFONY:
                break;

            default:
                throw new DomainException('Form type does not exist.');
        }

        return $form;
    }
}
