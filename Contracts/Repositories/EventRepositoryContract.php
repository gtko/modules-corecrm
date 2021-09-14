<?php


namespace Modules\CoreCRM\Contracts\Repositories;



use Modules\BaseCore\Contracts\Repositories\RelationsRepositoryContract;
use Modules\CoreCRM\Models\Event;

interface EventRepositoryContract extends RelationsRepositoryContract
{
    public function createEvent(string $key):Event;
}
