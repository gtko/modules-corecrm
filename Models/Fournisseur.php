<?php

namespace Modules\CoreCRM\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\BaseCore\Models\User;
use Spatie\Permission\Models\Role;

/**
 * Class Fournisseur
 * @package App\Models
 */
class Fournisseur extends User
{
    protected $table = 'users';

    public function newQuery(): Builder
    {
        return parent::newQuery()->role('fournisseur');
    }

    protected static function booted()
    {
        static::saved(function ($user) {
            $user->roles->sync([
                Role::find('name', 'fournisseur')
            ]);
        });
    }


    public function tagfournisseurs(){
        return $this->belongsToMany(Tagfournisseur::class,'fournisseur_tagfournisseur', 'fournisseur_id', 'tagfournisseur_id');
    }
}
