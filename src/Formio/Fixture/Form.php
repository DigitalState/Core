<?php

namespace Ds\Component\Formio\Fixture;

use Doctrine\Common\Persistence\ObjectManager;
use Ds\Component\Api\Api\Api;
use Ds\Component\Config\Service\ConfigService;
use Ds\Component\Formio\Exception\ValidationException;
use Ds\Component\Formio\Model\Form as FormModel;
use Ds\Component\Formio\Model\User as UserModel;
use Ds\Component\Database\Fixture\Yaml;

/**
 * Trait Form
 *
 * @package Ds\Component\Formio
 */
trait Form
{
    use Yaml;

    /**
     * @var string
     */
    private $path;

    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $fixtures = array_key_exists('FIXTURES', $_ENV) ? $_ENV['FIXTURES'] : 'dev';
        $configService = $this->container->get(ConfigService::class);

        $api = $this->container->get(Api::class)->get('formio.authentication');
        $user = new UserModel;
        $user
            ->setEmail($configService->get('ds_api.user.username'))
            ->setPassword($configService->get('ds_api.user.password'));
        $token = $api->login($user);

        $api = $this->container->get(Api::class)->get('formio.role');
        $api->setHeader('x-jwt-token', $token);
        $roles = $api->getList();

        $api = $this->container->get(Api::class)->get('formio.form');
        $api->setHeader('x-jwt-token', $token);
        $objects = $this->parse($this->getResource());

        foreach ($objects as $object) {
            try {
                $api->delete($object->path);
            } catch (ValidationException $exception) {
                // @todo this is so first time fixtures dont cause an error, handle "Invalid alias" better
            }

            $form = new FormModel;
            $object->components = json_decode(file_get_contents(dirname(str_replace('{fixtures}', $fixtures, $this->path)).'/'.$object->components));
            $object->submission_access = json_decode(file_get_contents(dirname(str_replace('{fixtures}', $fixtures, $this->path)).'/'.$object->submission_access));
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
