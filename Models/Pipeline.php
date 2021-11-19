<?php

namespace Modules\CoreCRM\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\CoreCRM\Enum\StatusTypeEnum;

/**
 * @property integer $id
 * @property string $name
 * @property boolean $is_default
 * @property integer $next_order_status
 * @property \Modules\CoreCRM\Models\Status status_new
 * @property \Modules\CoreCRM\Models\Status status_win
 * @property \Modules\CoreCRM\Models\Status status_lost
 * @property \Illuminate\Database\Eloquent\Collection $statuses
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class Pipeline extends Model
{

    protected $fillable = ['name', 'is_default'];

    protected $with = ['statuses'];

    public function statuses():HasMany
    {
        return $this->hasMany(Status::class)->orderBy('order', 'ASC');
    }


    public function getStatusNewAttribute()
    {
        return $this->statuses->where('type', StatusTypeEnum::TYPE_NEW)->first();
    }

    public function getStatusWinAttribute()
    {
        return $this->statuses->where('type', StatusTypeEnum::TYPE_WIN)->first();
    }

    public function getStatusLostAttribute()
    {
        return $this->statuses->where('type', StatusTypeEnum::TYPE_LOST)->first();
    }

    public function getNextOrderStatusAttribute()
    {
        return $this->statuses->count() - 3;
    }

}
