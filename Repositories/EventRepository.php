<?php


namespace Modules\CoreCRM\Repositories;

use Modules\CoreCRM\Contracts\Repositories\EventRepositoryContract;
use Modules\CoreCRM\Models\Event;

class EventRepository implements EventRepositoryContract
{

    public function createEvent(string $key): Event
    {
        $event = Event::where('key', $key)->firstOrNew();
        if($event->id ?? true){
            $event->key = $key;
            $event->save();
        }

        return $event;
    }
}
