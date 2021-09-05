<?php

namespace Modules\CoreCRM\Contracts\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\SearchCRM\Entities\SearchResult;

/**
 * @property int $id
 * @property string $ref
 */
Abstract class DevisEntities extends Model
{
    abstract public function dossier(): BelongsTo;
    abstract public function commercial(): BelongsTo;
    abstract public static function getNumStartRef(): int;
    abstract public function getSearchResult(): SearchResult;
}
