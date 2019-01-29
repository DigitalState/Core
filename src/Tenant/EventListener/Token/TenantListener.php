<?php

namespace Ds\Component\Tenant\EventListener\Token;

use Ds\Component\Tenant\Service\TenantService;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTDecodedEvent;

/**
 * Class TenantListener
 *
 * @package Ds\Component\Tenant
 */
final class TenantListener
{
    /**
     * @var \Ds\Component\Tenant\Service\TenantService
     */
    private $tenantService;

    /**
     * @var string
     */
    private $attribute;

    /**
     * Constructor
     *
     * @param \Ds\Component\Tenant\Service\TenantService $tenantService
     * @param string $attribute
     */
    public function __construct(TenantService $tenantService, string $attribute = 'tenant')
    {
        $this->tenantService = $tenantService;
        $this->attribute = $attribute;
    }

    /**
     * Add the user tenant to the token
     *
     * @param \Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent $event
     */
    public function created(JWTCreatedEvent $event)
    {
        $payload = $event->getData();
        $user = $event->getUser();
        $payload[$this->attribute] = $user->getTenant();
        $event->setData($payload);
    }

    /**
     * Mark the token as invalid if the user tenant is missing
     *
     * @param \Lexik\Bundle\JWTAuthenticationBundle\Event\JWTDecodedEvent $event
     */
    public function decoded(JWTDecodedEvent $event)
    {
        $payload = $event->getPayload();

        // Make property accessor paths compatible by converting payload to recursive associative array
        $payload = json_decode(json_encode($payload), true);

        if (!array_key_exists($this->attribute, $payload)) {
            $event->markAsInvalid();
        }

        $uuid = $payload[$this->attribute];
        $tenant = $this->tenantService->getRepository()->findBy(['uuid' => $uuid]);

        if (!$tenant) {
            $event->markAsInvalid();
        }
    }
}
