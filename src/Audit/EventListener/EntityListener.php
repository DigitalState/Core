<?php

namespace Ds\Component\Audit\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Ds\Component\Audit\Entity\Audit;
use Ds\Component\Audit\Model\Type\Auditable;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class EntityListener
 *
 * @package Ds\Component\Audit
 */
class EntityListener
{
    /**
     * @var \Symfony\Component\DependencyInjection\ContainerInterface
     */
    protected $container;

    /**
     * @var \Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface
     */
    protected $tokenStorage;

    /**
     * @var \Ds\Component\Config\Service\ConfigService
     */
    protected $configService;

    /**
     * @var \Ds\Component\Audit\Service\AuditService
     */
    protected $auditService;

    /**
     * Constructor
     *
     * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * Generate an audit entry after persisting an entity
     *
     * @param \Doctrine\ORM\Event\LifecycleEventArgs $args
     */
    public function postPersist(LifecycleEventArgs $args)
    {
        $this->execute($args, Audit::ACTION_ADD);
    }

    /**
     * Generate an audit entry after updating an entity
     *
     * @param \Doctrine\ORM\Event\LifecycleEventArgs $args
     */
    public function postUpdate(LifecycleEventArgs $args)
    {
        $this->execute($args, Audit::ACTION_EDIT);
    }

    /**
     * Generate an audit entry after persisting an entity
     *
     * @param \Doctrine\ORM\Event\LifecycleEventArgs $args
     * @param string $action
     */
    protected function execute(LifecycleEventArgs $args, $action)
    {
        // Circular reference error workaround
        // @todo Look into fixing this
        $this->tokenStorage = $this->container->get('security.token_storage');
        $this->configService = $this->container->get('ds_config.service.config');
        $this->auditService = $this->container->get('ds_audit.service.audit');
        //

        $entity = $args->getEntity();

        if ($entity instanceof Audit) {
            return;
        }

        if (!$entity instanceof Auditable) {
            return;
        }

        $token = $this->tokenStorage->getToken();

        if (!$token) {
            return;
        }

        $user = $token->getUser();
        $edits = $args->getEntityManager()->getUnitOfWork()->getEntityChangeSet($entity);
        $properties = $this->auditService->getProperties($entity);

        foreach (array_keys($edits) as $key) {
            if (!in_array($key, $properties)) {
                unset($edits[$key]);
            }
        }

        $audit = $this->auditService->createInstance();
        $audit
            ->setOwner($this->configService->get('ds_audit.audit.owner'))
            ->setOwnerUuid($this->configService->get('ds_audit.audit.owner_uuid'))
            ->setUserUuid($user->getUuid())
            ->setIdentity($user->getIdentity()->getType())
            ->setIdentityUuid($user->getIdentity()->getUuid())
            ->setAction($action)
            ->setData([
                'entity' => basename(str_replace('\\', '/', get_class($entity))),
                'entityUuid' => $entity->getUuid(),
                'edits' => $edits
            ]);

        $manager = $this->auditService->getManager();
        $manager->persist($audit);
        $manager->flush();
    }
}
