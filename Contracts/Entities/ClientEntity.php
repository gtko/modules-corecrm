<?php

namespace Modules\CoreCRM\Contracts\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\BaseCore\Interfaces\TypePersonne;
use Modules\BaseCore\Models\Scopes\HasPersonne;
use Modules\CoreCRM\Models\Dossier;
use Modules\SearchCRM\Entities\SearchResult;
use Modules\SearchCRM\Interfaces\SearchableModel;

/**
 * @property int $id
 * @property string $ref
 * @property mixed last_dossier
 */
Abstract class ClientEntity extends Model implements TypePersonne, SearchableModel
{
    use HasPersonne;
    use HasFactory;

    abstract public function dossiers(): HasMany;
    abstract public function getLastDossierAttribute(): ?Model;
    abstract public function getSearchResult(): SearchResult;
}
