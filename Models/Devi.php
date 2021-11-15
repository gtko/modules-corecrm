<?php

namespace Modules\CoreCRM\Models;

use App\Models\Brand;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Modules\BaseCore\Contracts\Entities\UserEntity;
use Modules\BaseCore\Models\User;
use Modules\CoreCRM\Contracts\Entities\DevisEntities;
use Modules\CoreCRM\Models\Scopes\HasRef;
use Modules\SearchCRM\Entities\SearchResult;
use Modules\SearchCRM\Interfaces\SearchableModel;
use Modules\SignatureCRM\Models\Signature;

/**
 * Class Devi
 *
 * @package App\Models
 * @property array $data
 * @property Dossier $dossier
 * @property Commercial $commercial
 * @property Fournisseur $fournisseur
 * @property Brand $brand
 * @mixin Builder
 * @mixin \Illuminate\Database\Query\Builder
 */
class Devi extends DevisEntities implements SearchableModel
{
    use HasFactory;
    use HasRef;

    protected $with = ['dossier.client'];

    protected $fillable = [
        'dossier_id',
        'commercial_id',
        'data',
        'tva_applicable',
    ];

    protected $casts = [
        'data' => 'array',
        'tva_applicable' => 'boolean',
    ];

    public function dossier(): BelongsTo
    {
        return $this->belongsTo(Dossier::class);
    }

    public function commercial(): BelongsTo
    {
        return $this->belongsTo(app(UserEntity::class)::class, 'commercial_id');
    }

    public static function getNumStartRef(): int
    {
        return 48958;
    }

    public function getSearchResult(): SearchResult
    {
        $result = new SearchResult(
            $this,
            "#{$this->ref} - " . $this->dossier->client->format_name,
            route('devis.edit', [$this->dossier->client, $this->dossier, $this]),
            'devis',
            html:"<small>{$this->created_at->format('d/m/Y')}</small> - <small>{$this->commercial->format_name}</small>"
        );

        $result->setImg($this->dossier->client->avatar_url);

        return $result;
    }



}
