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
        // @todo remove dependency on ds_api, add formio api services
        $api = $this->container->get('ds_api.api')->get('formio.authentication');
        $user = new User;
        $user
            ->setEmail('webmaster@digitalstate.ca')
            ->setPassword('changeme');
        $token = $api->login($user);
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
            $entry
                ->setTitle($form['title'])
                ->setDisplay($form['display'])
                ->setType($form['type'])
                ->setName($form['name'])
                ->setPath($form['path'])
                ->setTags($form['tags'])
                ->setComponents($form['components']);
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
