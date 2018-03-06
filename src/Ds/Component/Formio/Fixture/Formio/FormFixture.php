<?php

namespace Ds\Component\Formio\Fixture\Formio;

use Doctrine\Common\Persistence\ObjectManager;
use Ds\Component\Formio\Exception\ValidationException;
use Ds\Component\Formio\Model\Form;
use Ds\Component\Formio\Model\User;
use Ds\Component\Database\Fixture\ResourceFixture;

/**
 * Class FormFixture
 *
 * @package Ds\Component\Formio
 */
abstract class FormFixture extends ResourceFixture
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $configService = $this->container->get('ds_config.service.config');

        // @todo remove dependency on ds_api, add formio api services
        $api = $this->container->get('ds_api.api')->get('formio.authentication');
        $user = new User;
        $user
            ->setEmail($configService->get('ds_api.user.username'))
            ->setPassword($configService->get('ds_api.user.password'));
        $token = $api->login($user);

        $api = $this->container->get('ds_api.api')->get('formio.role');
        $api->setHeader('x-jwt-token', $token);
        $roles = $api->getList();

        $api = $this->container->get('ds_api.api')->get('formio.form');
        $api->setHeader('x-jwt-token', $token);
        $forms = $this->parse($this->getResource());

        foreach ($forms as $form) {
            try {
                $api->delete($form['path']);
            } catch (ValidationException $exception) {
                // @todo this is so first time fixtures dont cause an error, handle "Invalid alias" better
            }

            $entry = new Form;
            $submissionAccess = [];

            foreach ($form['submission_access'] as $access) {
                foreach ($access['roles'] as $key => $value) {
                    foreach ($roles as $role) {
                        if ($role->getMachineName() === $value) {
                            $access['roles'][$key] = $role->getId();
                            break;
                        }
                    }
                }

                $submissionAccess[] = $access;
            }

            $entry
                ->setTitle($form['title'])
                ->setDisplay($form['display'])
                ->setType($form['type'])
                ->setName($form['name'])
                ->setPath($form['path'])
                ->setTags($form['tags'])
                ->setComponents($form['components'])
                ->setSubmissionAccess($submissionAccess);
            $api->create($entry);
        }
    }

    /**
     * Get resource
     *
     * @return string
     */
    abstract protected function getResource();
}
