<?php

namespace Modules\CoreCRM\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Status
 * @package Modules\CoreCRM\Models
 * @property string $label
 * @property string $color
 * @property int $order
 * @property string $type
 * @property int $pipeline_id
 * @property \Modules\CoreCRM\Models\Pipeline $pipeline
 * @mixin Builder
 * @mixin \Illuminate\Database\Query\Builder
 */
class Status extends Model
{
    use HasFactory;

    protected $fillable = ['label', 'order', 'color', 'type', 'pipeline_id'];

    public function dossiers()
    {
        return $this->hasMany(Dossier::class);
    }

    public function pipeline():BelongsTo
    {
        return $this->belongsTo(Pipeline::class);
    }
}
