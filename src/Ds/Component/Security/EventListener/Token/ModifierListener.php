<?php

namespace Ds\Component\Security\EventListener\Token;

use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTDecodedEvent;
use OutOfRangeException;

/**
 * Class ModifierListener
 */
class ModifierListener
{
    /**
     * @var array
     */
    protected $remove;

    /**
     * Constructor
     *
     * @param array $remove
     */
    public function __construct(array $remove = [])
    {
        $this->remove = $remove;
    }

    /**
     * On created
     *
     * @param \Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent $event
     * @throws \OutOfRangeException
     */
    public function onCreated(JWTCreatedEvent $event)
    {
        $payload = $event->getData();

        foreach ($this->remove as $attribute) {
            if (!array_key_exists($attribute, $payload)) {
                throw new OutOfRangeException('Payload attribute does not exist.');
            }

            unset($payload[$attribute]);
        }

        $event->setData($payload);
    }

    /**
     * On decoded
     *
     * @param \Lexik\Bundle\JWTAuthenticationBundle\Event\JWTDecodedEvent $event
     */
    public function onDecoded(JWTDecodedEvent $event)
    {
        $payload = $event->getPayload();

        foreach ($this->remove as $attribute) {
            if (array_key_exists($attribute, $payload)) {
                $event->markAsInvalid();
                break;
            }
        }
    }
}
