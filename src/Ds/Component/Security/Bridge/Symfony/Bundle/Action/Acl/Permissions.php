<?php

namespace Ds\Component\Security\Bridge\Symfony\Bundle\Action\Acl;

use Ds\Component\Security\Collection\PermissionCollection;
use Symfony\Component\HttpFoundation\JsonResponse;

use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * Class Permissions
 */
class Permissions
{
    /**
     * @var \Ds\Component\Security\Collection\PermissionCollection
     */
    protected $permissionCollection;

    /**
     * Constructor
     *
     * @param \Ds\Component\Security\Collection\PermissionCollection $permissionCollection
     */
    public function __construct(PermissionCollection $permissionCollection)
    {
        $this->permissionCollection = $permissionCollection;
    }

    /**
     * Action
     *
     * @Route(path="/acl/permissions")
     * @Method("GET")
     */
    public function __invoke()
    {
        $permissions = $this->permissionCollection->toArray();

        return new JsonResponse($permissions);
    }
}
