<?php

namespace Ds\Component\Security\Bridge\Symfony\Bundle\Action\Security;

use Ds\Component\Security\Collection\PermissionCollection;
use Ds\Component\Security\Model\Permission;
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
        $transformed = [];

        foreach ($permissions as $key => $permission) {
            switch ($permission['type']) {
                case Permission::FIELD:
                    $permission['entity'] = $this->getEntityKey($permission['subject'], $permissions);
                    break;
            }

            $transformed[$key] = $permission;
            unset($transformed[$key]['subject']);
        }

        return new JsonResponse($transformed);
    }

    /**
     * Get entity key for a given subject
     *
     * @param string $subject
     * @param array $permissions
     * @return string|null
     */
    protected function getEntityKey($subject, $permissions)
    {
        foreach ($permissions as $permission) {
            if (Permission::ENTItY === $permission['type'] && 0 === strpos($subject, $permission['subject'])) {
                return $permission['key'];
            }
        }
    }
}
