<?php


namespace Modules\CoreCRM\Flow\Attributes;


use Illuminate\Database\Eloquent\Model;
use Modules\CoreCRM\Contracts\Repositories\EventRepositoryContract;
use Modules\CoreCRM\Flow\Interfaces\FlowAttributes;
use Modules\CoreCRM\Models\Event;

abstract class Attributes implements FlowAttributes
{

    protected ?Model $model;
    protected Event $event;

    public function __construct(){
        $this->event = app(EventRepositoryContract::class)->createEvent($this->getKeyEvent());
    }

    public function event(): Event
    {
       return $this->event;
    }

    public function model(): ?Model
    {
        return $this->model ?? null;
    }

    public function setModel(Model $model)
    {
        $this->model = $model;
    }

    public function toJson(): string
    {
        return json_encode($this->toArray(), JSON_THROW_ON_ERROR);
    }

    public function getKeyEvent(): string
    {
        return get_class($this);
    }

}
