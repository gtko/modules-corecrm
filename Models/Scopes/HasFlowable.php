<?php


namespace Modules\CoreCRM\Models\Scopes;


use Illuminate\Database\Eloquent\Relations\MorphMany;
use Modules\CoreCRM\Models\Flow;

/**
 * @method morphMany(string $class, string $string)
 */
trait HasFlowable
{

    public function flow():MorphMany
    {
        return $this->morphMany(Flow::class, 'flowable');
    }

}
