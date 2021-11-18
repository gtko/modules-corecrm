<?php

namespace Modules\CoreCRM\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property integer $id
 * @property string $name
 * @property boolean $is_default
 * @property \Illuminate\Database\Eloquent\Collection $statuses
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class Pipeline extends Model
{

    protected $fillable = ['name', 'is_default'];


    public function statuses():HasMany
    {
        return $this->hasMany(Status::class)->orderBy('order', 'ASC');
    }
}
