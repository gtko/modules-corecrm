<?php

namespace Modules\CoreCRM\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $name
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Modules\CoreCRM\Models\Fournisseur[] $fournisseurs
 */
class Tagfournisseur extends Model
{

    public $fillable = [
        'name',
    ];

    public function fournisseurs()
    {
        return $this->belongsToMany(Fournisseur::class, 'fournisseur_tagfournisseur', 'tagfournisseur_id', 'fournisseur_id');
    }

}
