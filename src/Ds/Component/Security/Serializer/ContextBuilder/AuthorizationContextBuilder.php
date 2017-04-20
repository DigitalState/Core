<?php

namespace Ds\Component\Security\Serializer\ContextBuilder;

use ApiPlatform\Core\Serializer\SerializerContextBuilderInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class AuthorizationContextBuilder
 */
class AuthorizationContextBuilder implements SerializerContextBuilderInterface
{
    /**
     * @var string
     */
    protected $entity;

    /**
     * @var array
     */
    protected $permissions;

    /**
     * @var \ApiPlatform\Core\Serializer\SerializerContextBuilderInterface
     */
    protected $decorated;

    /**
     * @var \Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface
     */
    protected $authorizationChecker;

    /**
     * Constructor
     *
     * @param string $entity
     * @param array $permissions
     * @param \ApiPlatform\Core\Serializer\SerializerContextBuilderInterface $decorated
     * @param \Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface $authorizationChecker
     */
    public function __construct($entity, array $permissions, SerializerContextBuilderInterface $decorated, AuthorizationCheckerInterface $authorizationChecker)
    {
        $this->entity = $entity;
        $this->permissions = $permissions;
        $this->decorated = $decorated;
        $this->authorizationChecker = $authorizationChecker;
    }

    /**
     * {@inheritdoc}
     */
    public function createFromRequest(Request $request, bool $normalization, array $extractedAttributes = null) : array
    {
        $context = $this->decorated->createFromRequest($request, $normalization, $extractedAttributes);

        if ($this->entity !== $extractedAttributes['resource_class']) {
            return $context;
        }

        if (!array_key_exists('groups', $context)) {
            $context['groups'] = [];
        }

        $operation = null;

        if (array_key_exists('item_operation_name', $extractedAttributes)) {
            $operation = $extractedAttributes['item_operation_name'];
        } elseif (array_key_exists('collection_operation_name', $extractedAttributes)) {
            $operation = 'c'.$extractedAttributes['collection_operation_name'];
        }

        foreach ($this->permissions as $role => $permissions) {
            if (!$this->authorizationChecker->isGranted($role)) {
                continue;
            }

            foreach ($permissions as $group => $attributes) {
                switch ($operation) {
                    case 'get':
                        if (in_array('READ', $attributes)) {
                            $context['groups'][] = $group;
                        }

                        break;

                    case 'cget':
                        if (in_array('BROWSE', $attributes)) {
                            $context['groups'][] = $group;
                        }

                        break;
                }
            }
        }

        return $context;
    }
}
