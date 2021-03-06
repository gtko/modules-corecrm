<?php

namespace Modules\CoreCRM\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\TimerCRM\Contracts\Repositories\TimerRepositoryContract;
use Spatie\Permission\Models\Role;
use Rennokki\QueryCache\Traits\QueryCacheable;

class Commercial extends User
{
//    use QueryCacheable;

//    public $cacheFor = 3600;

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

    public function dossiers()
    {
        return $this->hasMany(Dossier::class);
    }


}
