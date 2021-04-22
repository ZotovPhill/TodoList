<?php

namespace App\Event;

final class EventStore
{
    private static $events;

    public static function remember(AppEvent $event)
    {
        self::$events[] = $event;
    }

    /**
     * @return AppEvent[]
     */
    public static function release(): array
    {
        [$events, self::$events] = [(array) self::$events, []];

        return $events;
    }
}
