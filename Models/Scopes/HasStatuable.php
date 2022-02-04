<?php


namespace Modules\CoreCRM\Models\Scopes;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\CoreCRM\Models\Status;

/**
 * Trait HasStatuable
 * @property Status $status
 * @property string $status_label
 * @property int $status_weight
 * @package Modules\CoreCRM\Models\Scopes
 */
trait HasStatuable
{

    public function newQuery(): Builder
    {
        return parent::newQuery();
    }

    public function status():BelongsTo
    {
        return $this->belongsTo(Status::class);
    }

    public function getStatusLabelAttribute()
    {
        return $this->status->label ?? '';
    }

    public function getStatusWeightAttribute()
    {
        return $this->status->weight ?? 0;
    }

    public function getStatusColorAttribute()
    {
        return $this->status->color ?? 'gray';
    }

}
