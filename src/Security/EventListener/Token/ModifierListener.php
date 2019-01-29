<?php

namespace Ds\Component\Security\EventListener\Token;

use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTDecodedEvent;
use OutOfRangeException;

/**
 * Class ModifierListener
 *
 * @package Ds\Component\Security
 */
final class ModifierListener
{
    /**
     * @var array
     */
    private $removed;

    /**
     * Constructor
     *
     * @param array $removed
     */
    public function __construct(array $removed = [])
    {
        $this->removed = $removed;
    }

    /**
     * Modify the jwt token
     *
     * @param \Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent $event
     * @throws \OutOfRangeException
     */
    public function created(JWTCreatedEvent $event)
    {
        $data = $event->getData();

        foreach ($this->removed as $property) {
            if (!array_key_exists($property, $data)) {
                throw new OutOfRangeException('Property does not exist.');
            }

            unset($data[$property]);
        }

        $event->setData($data);
    }

    /**
     * Mark the token as invalid if the token is not modified
     *
     * @param \Lexik\Bundle\JWTAuthenticationBundle\Event\JWTDecodedEvent $event
     */
    public function decoded(JWTDecodedEvent $event)
    {
        $payload = $event->getPayload();

        // Make property accessor paths compatible by converting payload to recursive associative array
        $payload = json_decode(json_encode($payload), true);

        foreach ($this->removed as $property) {
            if (array_key_exists($property, $payload)) {
                $event->markAsInvalid();
                break;
            }
        }
    }
}
