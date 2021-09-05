<?php


namespace Modules\CoreCRM\Flow;


use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Modules\CoreCRM\Flow\Interfaces\FlowAttributes;
use Modules\CoreCRM\Models\Event;

class FlowResolveCast implements CastsAttributes
{
    protected function resolve(Event $event, array $values): FlowAttributes
    {
        return ($event->key)::instance($values);
    }

    public function get($model, string $key, $value, array $attributes)
    {
        if($value) {
            $values = json_decode($value, true, 512, JSON_THROW_ON_ERROR);
            return $this->resolve($model->event, $values);
        }

        return null;
    }

    public function set($model, string $key, $value, array $attributes):string
    {
        return $value->toJson();
    }
}
