<?php

namespace Ds\Component\Security\Bridge\Symfony\Bundle\Action\Permissions;

use Ds\Component\Security\Collection\PermissionCollection;
use Ds\Component\Security\Model\Permission;
use Symfony\Component\HttpFoundation\JsonResponse;

use ApiPlatform\Core\Annotation\ApiResource;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ListAction
 *
 * @package Ds\Component\Security
 * @ApiResource
 */
class ListAction
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
     * @Method("GET")
     * @Route(path="/permissions/list")
     * @Security("is_granted('BROWSE', 'permissions_list')")
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function cget()
    {
        $permissions = [];

        foreach ($this->permissionCollection as $key => $element) {
            $permission = $element->toObject();

            switch ($permission->type) {
                case Permission::PROPERTY:
                    $parent = $this->permissionCollection->getParent($element);

                    if ($parent) {
                        $permission->parent = $parent->getKey();
                    }

                    break;
            }

            unset($permission->value);
            $permissions[] = $permission;
        }

        return new JsonResponse($permissions);
    }
}
