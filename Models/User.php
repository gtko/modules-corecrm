<?php

namespace Modules\CoreCRM\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\BaseCore\Contracts\Entities\UserEntity;
use Rennokki\QueryCache\Traits\QueryCacheable;

class User extends \Modules\BaseCore\Models\User
{


//    use QueryCacheable;
//    protected $cacheFor = 3600;

    public function isCommercial():bool
    {
        return $this->hasRole('commercial');
    }

    public function isCommercialOnly():bool
    {
        return $this->hasRole('commercial') && !$this->isSuperAdmin();
    }

    public function dossiers()
    {
        return $this->BelongsToMany(Dossier::class);
    }

    public function dossiersFollower():BelongsToMany
    {
        return $this->belongsToMany(Dossier::class, 'dossier_user', 'user_id', 'dossier_id');
    }

}
