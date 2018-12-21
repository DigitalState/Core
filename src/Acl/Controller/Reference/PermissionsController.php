<?php

namespace Ds\Component\Acl\Controller\Reference;

use Ds\Component\Acl\Collection\PermissionCollection;
use Ds\Component\Acl\Model\Permission;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class PermissionsController
 *
 * @package Ds\Component\Acl
 */
final class PermissionsController
{
    /**
     * @var \Ds\Component\Acl\Collection\PermissionCollection
     */
    private $permissionCollection;

    /**
     * Constructor
     *
     * @param \Ds\Component\Acl\Collection\PermissionCollection $permissionCollection
     */
    public function __construct(PermissionCollection $permissionCollection)
    {
        $this->permissionCollection = $permissionCollection;
    }

    /**
     * Action
     *
     * @Route(path="/reference/permissions", methods={"GET"})
     * @Security("is_granted('BROWSE', 'reference_permissions')")
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

        return new JsonResponse($permissions, Response::HTTP_OK, [
            'Content-Type' => 'application/json; charset=utf-8'
        ]);
    }
}
