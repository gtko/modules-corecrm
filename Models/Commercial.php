<?php

namespace Modules\CoreCRM\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\BaseCore\Models\User;
use Modules\TimerCRM\Contracts\Repositories\TimerRepositoryContract;
use Spatie\Permission\Models\Role;

class Commercial extends User
{
    protected $table = 'users';

//    public function newQuery(): Builder
//    {
//        return parent::newQuery();
//    }
//
//    protected static function booted()
//    {
//        static::saved(function ($user) {
//            $user->roles->sync([
//                Role::find('name', 'commercial')
//            ]);
//        });
//    }

    public function getIsActifAttribute()
    {
        if(app(TimerRepositoryContract::class)->fetchTimerStarted($this) != null)
        {
            return true;
        } else {
            return false;
        }


    }

    public function timer(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Timer::class);
    }

    public function dossiers(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Dossier::class);
    }


}
