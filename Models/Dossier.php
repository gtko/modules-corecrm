<?php

namespace Modules\CoreCRM\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\BaseCore\Icons\Icons;
use Modules\CoreCRM\Contracts\Entities\ClientEntity;
use Modules\CoreCRM\Contracts\Entities\DevisEntities;
use Modules\CoreCRM\Interfaces\Flowable;
use Modules\CoreCRM\Models\Scopes\CanAppel;
use Modules\CoreCRM\Models\Scopes\HasFlowable;
use Modules\CoreCRM\Models\Scopes\HasRef;
use Modules\CoreCRM\Models\Scopes\HasStatuable;
use Modules\CrmAutoCar\Models\Tag;
use Modules\SearchCRM\Entities\SearchResult;
use Modules\SearchCRM\Interfaces\SearchableModel;

/**
 * Class Dossier
 * @package Modules\CoreCRM\Models
 * @property Commercial $commercial
 * @property ClientEntity $client
 * @property Collection $appels
 * @property Carbon $date_start
 * @property Source $source
 * @property Tag $tag
 * @mixin Builder
 * @mixin \Illuminate\Database\Query\Builder
 */
class Dossier extends Model implements SearchableModel, Flowable
{
    use HasFactory;
    use HasRef;
    use HasStatuable;
    use HasFlowable;
    use CanAppel;

    protected $fillable = [
        'clients_id',
        'source_id',
        'status_id',
        'commercial_id',
        'date_start',
    ];

    protected array $searchableFields = ['*'];

    protected $casts = [
        'date_start' => 'datetime',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(app(ClientEntity::class)::class, 'clients_id');
    }

    public function devis(): HasMany
    {
        return $this->hasMany(app(DevisEntities::class)::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }

    public function source(): BelongsTo
    {
        return $this->belongsTo(Source::class);
    }

    public function commercial(): BelongsTo
    {
        return $this->belongsTo(Commercial::class, 'commercial_id');
    }

    public function getSearchResult(): SearchResult
    {
        $label = "#" . $this->ref . ' - ' . $this->client->format_name;
        $result = new SearchResult($this, $label, route('dossiers.show', [
            'client' => $this->client,
            'dossier' => $this
        ]),
            'dossiers',
            html: "<small>{$this->status->label}</small> - <small>{$this->commercial->format_name}</small>"
        );
        $result->setSvg(Icons::folder());
        return $result;
    }

    static function getNumStartRef(): int
    {
        return 1548;
    }
}
