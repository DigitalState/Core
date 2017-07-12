<?php

namespace Ds\Component\Security\Bridge\Symfony\Bundle\Action\Security;

use Ds\Component\Security\Collection\PermissionCollection;
use Ds\Component\Security\Model\Permission;
use Symfony\Component\HttpFoundation\JsonResponse;

use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

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
     * @Method("GET")
     * @Route(path="/permissions")
     * @Security("is_granted('BROWSE', {type:'property', value:'Ds\Component\Security\Entity\Access.id', entity:'BusinessUnit', entity_uuid:'c11c546e-bd01-47cf-97da-e25388357b5a'})")
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

            unset($permission->subject);
            $permissions[] = $permission;
        }

        return new JsonResponse($permissions);
    }
}
