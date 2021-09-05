<?php

namespace Modules\CoreCRM\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\BaseCore\Models\User;
use Spatie\Permission\Models\Role;

class Commercial extends User
{
    protected $table = 'users';

    public function newQuery(): Builder
    {
        return parent::newQuery()->role(['commercial', 'super-admin']);
    }

    protected static function booted()
    {
        static::saved(function ($user) {
            $user->roles->sync([
                Role::find('name', 'commercial')
            ]);
        });
    }

    public function timer() {
        return $this->hasMany(Timer::class);
    }

}
