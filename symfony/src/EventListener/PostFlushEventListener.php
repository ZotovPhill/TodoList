<?php

namespace App\EventListener;

use App\Event\EventStore;
use Doctrine\ORM\Event\PostFlushEventArgs;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class PostFlushEventListener
{
    private $dispatcher;

    public function __construct(EventDispatcherInterface $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    public function postFlush(PostFlushEventArgs $args)
    {
        $em = $args->getEntityManager();

        if ($em->getConnection()->getTransactionNestingLevel() > 0) {
            return;
        }

        $events = EventStore::release();
        if (empty($events)) {
            return;
        }

        foreach ($events as $event) {
            $this->dispatcher->dispatch($event);
        }

        $em->flush();
    }
}
