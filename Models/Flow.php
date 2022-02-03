<?php

namespace Modules\CoreCRM\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Modules\CoreCRM\Flow\FlowResolveCast;
use Rennokki\QueryCache\Traits\QueryCacheable;

/**
 * Class Flow
 * @property int $id
 * @property Event $event
 * @property Model $flowable
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @package App\Models
 */
class Flow extends Model
{
    use QueryCacheable;

    protected $casts = [
        'datas' => FlowResolveCast::class,
    ];

    public function event():BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function flowable():MorphTo
    {
        return $this->morphTo('flowable');
    }

}
