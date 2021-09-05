<?php


namespace Modules\CoreCRM\Contracts\Repositories;



use Modules\CoreCRM\Models\Event;

interface EventRepositoryContract
{
    public function createEvent(string $key):Event;
}
