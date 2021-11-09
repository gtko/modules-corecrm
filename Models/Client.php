<?php

namespace Modules\CoreCRM\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Modules\BaseCore\Interfaces\TypePersonne;
use Modules\BaseCore\Models\Personne;
use Modules\BaseCore\Models\Scopes\HasPersonne;
use Modules\CoreCRM\Contracts\Entities\ClientEntity;
use Modules\SearchCRM\Entities\SearchResult;
use Modules\SearchCRM\Interfaces\SearchableModel;

/**
 * Class Client
 * @property Collection $dossiers
 * @package Modules\CoreCRM\Models*
 * @mixin Builder
 * @mixin \Illuminate\Database\Query\Builder
 */
class Client extends ClientEntity
{
    use HasFactory;
    use HasPersonne;
    use Notifiable;

    protected $fillable = ['personne_id'];

    protected array $searchableFields = ['*'];

    public function Dossiers(): HasMany
    {
        return $this->hasMany(Dossier::class, 'clients_id');
    }

    public function getSearchResult(): SearchResult
    {
        $result = new SearchResult(
            $this,
            $this->format_name,
            route('clients.show', $this->id),
            'clients',
            html:"<small>{$this->email}</small> - <small>{$this->phone}</small>"
        );
        $result->setImg($this->avatar_url);
        return $result;
    }

    public function getLastDossierAttribute(): ?Model
    {
        return $this->dossiers()->orderBy('created_at', 'DESC')->first();
    }
}
