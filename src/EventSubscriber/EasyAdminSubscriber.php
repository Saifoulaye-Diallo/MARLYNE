<?php

namespace App\EventSubcriber;

use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityUpdatedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class EasyAdminSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            BeforeEntityPersistedEvent::class=>['setIlustration'],
            BeforeEntityUpdatedEvent::class=>['updateilustration']
        ];
    }

    public function updateilustration(BeforeEntityUpdatedEvent $event)
    {
        $entity= $event->getEntityInstance();
    }

    public function setIlustration(BeforeEntityPersistedEvent $event)
    {
        $entity= $event->getEntityInstance();
    }
}