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
        $env = $this->container->get('kernel')->getEnvironment();

        // @todo create mock server instead of skipping fixture
        if ('test' === $env) {
            return;
        }

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
        $objects = $this->parse($this->getResource());

        foreach ($objects as $object) {
            try {
                $api->delete($object->path);
            } catch (ValidationException $exception) {
                // @todo this is so first time fixtures dont cause an error, handle "Invalid alias" better
            }

            $form = new Form;
            $object->components = json_decode(file_get_contents(dirname(str_replace('{env}', $env, $this->getResource())).'/'.$object->components));
            $object->submission_access = json_decode(file_get_contents(dirname(str_replace('{env}', $env, $this->getResource())).'/'.$object->submission_access));
            $submissionAccess = [];

            foreach ($object->submission_access as $access) {
                foreach ($access->roles as $key => $value) {
                    foreach ($roles as $role) {
                        if ($role->getMachineName() === $value) {
                            $access->roles[$key] = $role->getId();
                            break;
                        }
                    }
                }

                $submissionAccess[] = $access;
            }

            $form
                ->setTitle($object->title)
                ->setDisplay($object->display)
                ->setType($object->type)
                ->setName($object->name)
                ->setPath($object->path)
                ->setTags($object->tags)
                ->setComponents($object->components)
                ->setSubmissionAccess($submissionAccess);
            $api->create($form);
        }
    }
}
