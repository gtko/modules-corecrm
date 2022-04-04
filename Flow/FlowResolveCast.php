<?php


namespace Modules\CoreCRM\Flow;


use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use Modules\CoreCRM\Flow\Interfaces\FlowAttributes;
use Modules\CoreCRM\Models\Event;

class FlowResolveCast implements CastsAttributes
{
    protected function resolve(Model $model, array $values): FlowAttributes
    {
        $instance = ($model->event->key)::instance($values);
        $instance->setModel($model);

        return $instance;
    }

    public function get($model, string $key, $value, array $attributes)
    {
        if($value) {
            $values = json_decode($value, true, 512, JSON_THROW_ON_ERROR);
            return $this->resolve($model, $values);
        }

        return null;
    }

    public function set($model, string $key, $value, array $attributes):string
    {
        return $value->toJson();
    }
}
