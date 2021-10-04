<?php

namespace Modules\CoreCRM\Contracts\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Modules\SearchCRM\Entities\SearchResult;

/**
 * @property int $id
 * @property string $ref
 * @property Carbon created_at
 * @property Carbon updated_at
 */
Abstract class DevisEntities extends Model
{
    abstract public function dossier(): BelongsTo;
    abstract public function commercial(): BelongsTo;
    abstract public static function getNumStartRef(): int;
    abstract public function getSearchResult(): SearchResult;

    public function getTotal(): float{
        return 0;
    }
}
