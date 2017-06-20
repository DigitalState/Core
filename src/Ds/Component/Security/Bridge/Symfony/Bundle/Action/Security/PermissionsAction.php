<?php

namespace Ds\Component\Security\Bridge\Symfony\Bundle\Action\Security;

use Ds\Component\Security\Collection\PermissionCollection;
use Symfony\Component\HttpFoundation\JsonResponse;

use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * Class PermissionsAction
 *
 * @ApiResource
 */
class PermissionsAction
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
     * @Route(path="/permissions")
     * @Method("GET")
     */
    public function cget()
    {
        $permissions = $this->permissionCollection->toArray();

        foreach ($permissions as $key => $permission) {
            unset($permission['subject']);
            $permissions[$key] = $permission;
        }

        return new JsonResponse($permissions);
    }
}
