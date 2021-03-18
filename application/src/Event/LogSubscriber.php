<?php

namespace App\Event;

use App\Entity\LogEntity;
use App\Entity\LogInterface;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use Doctrine\ORM\ORMException;

class LogSubscriber implements EventSubscriber
{
    /**
     * @inheritDoc
     */
    public function getSubscribedEvents()
    {
        return [
            Events::postUpdate,
            Events::preRemove
        ];
    }

    /**
     * @var bool
     */
    private $entraPostUpdate;

    /**
     * @param LifecycleEventArgs $lifecycleEventArgs
     * @throws ORMException
     */
    public function postUpdate(LifecycleEventArgs $lifecycleEventArgs): void
    {
        $entity = $lifecycleEventArgs->getEntity();
        if (! $entity instanceof LogInterface) {
            return;
        }

        $this->logChangeSet($lifecycleEventArgs, 0);
    }

    /**
     * @param LifecycleEventArgs $lifecycleEventArgs
     * @throws ORMException
     */
    public function preRemove(LifecycleEventArgs $lifecycleEventArgs): void
    {
        $entity = $lifecycleEventArgs->getEntity();
        if (! $entity instanceof LogInterface) {
            return;
        }

        $this->logChangeSet($lifecycleEventArgs, 1);
    }

    /**
     * Logs entity changeset
     * @throws \Doctrine\ORM\ORMException
     */
    private function logChangeSet(LifecycleEventArgs $lifecycleEventArgs, $tipoAcao): void
    {
        $entityManager = $lifecycleEventArgs->getEntityManager();
        $unitOfWork = $entityManager->getUnitOfWork();
        $entity = $lifecycleEventArgs->getEntity();
        $classMetadata = $entityManager->getClassMetadata(get_class($entity));

        /** @var LogInterface $entity */
        $unitOfWork->computeChangeSet($classMetadata, $entity);
        $changeSet = $unitOfWork->getEntityChangeSet($entity);

        $logs = $entity->getUpdateLogMessage($changeSet, $entity);

        if (!$this->entraPostUpdate) {
        $logEntity = new LogEntity(get_class($entity), $entity->id, $logs[0], $logs[1], 1, $tipoAcao, 1);
        $entityManager->persist($logEntity);
        $entityManager->flush();
        }
        $this->entraPostUpdate = true;
    }
}