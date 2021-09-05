<?php

namespace Modules\CoreCRM\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\BaseCore\Contracts\Entities\UserEntity;


/**
 * Class document
 *
 * @package Modules\CoreCRM\Models
 * @property array $data
 * @property Dossier $dossier
 * @property int $dossier_id
 * @property string $name
 * @property string path
 * @mixin Builder
 * @mixin \Illuminate\Database\Query\Builder
 */
class Document extends Model
{
    use HasFactory;


    protected $fillable = [
        'dossier_id',
        'name',
        'path',
    ];

    protected array $searchableFields = ['*'];



    public function dossier(): BelongsTo
    {
        return $this->belongsTo(Dossier::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(app(UserEntity::class)::class);
    }
}
