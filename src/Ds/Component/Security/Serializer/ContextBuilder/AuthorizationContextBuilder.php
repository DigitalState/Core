<?php

namespace Ds\Component\Security\Serializer\ContextBuilder;

use ApiPlatform\Core\Serializer\SerializerContextBuilderInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Paginator;
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
    protected $groups;

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
     * @param array $context
     * @param \ApiPlatform\Core\Serializer\SerializerContextBuilderInterface $decorated
     * @param \Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface $authorizationChecker
     */
    public function __construct($entity, array $groups, SerializerContextBuilderInterface $decorated, AuthorizationCheckerInterface $authorizationChecker)
    {
        $this->entity = $entity;
        $this->groups = $groups;
        $this->decorated = $decorated;
        $this->authorizationChecker = $authorizationChecker;
    }

    /**
     * {@inheritdoc}
     */
    public function createFromRequest(Request $request, bool $normalization, array $extractedAttributes = null) : array
    {
        $context = $this->decorated->createFromRequest($request, $normalization, $extractedAttributes);
        $data = $request->attributes->get('data');

        if ($data instanceof Paginator) {
            foreach ($data as $item) {
                if (!$item instanceof $this->entity) {
                    return $context;
                }
            }
        } elseif (!$data instanceof $this->entity) {
            return $context;
        }

        foreach ($this->groups as $role => $groups) {
            if (!$this->authorizationChecker->isGranted($role)) {
                continue;
            }

            $context['groups'] = array_merge($context['groups'], $groups[($normalization ? '' : 'de').'normalization']);
        }

        return $context;
    }
}
