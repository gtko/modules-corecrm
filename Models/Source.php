<?php

namespace Modules\CoreCRM\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Source
 * @property int $id
 * @property string $label
 * @property Collection $dossiers
 * @package Modules\CoreCRM\Models
 * @mixin Builder
 * @mixin \Illuminate\Database\Query\Builder
 */
class Source extends Model
{
    use HasFactory;

    protected $fillable = ['label'];

    public function dossiers(): HasMany
    {
        return $this->hasMany(Dossier::class);
    }
}
