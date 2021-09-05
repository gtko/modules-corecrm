<?php

namespace Modules\CoreCRM\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Status
 * @package Modules\CoreCRM\Models
 * @property string $label
 * @property int $weight
 * @property string $color
 * @mixin Builder
 * @mixin \Illuminate\Database\Query\Builder
 */
class Status extends Model
{
    use HasFactory;

    protected $fillable = ['label', 'weight', 'color'];

    protected $searchableFields = ['*'];

    public function dossiers()
    {
        return $this->hasMany(Dossier::class);
    }
}
