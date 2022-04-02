<?php

namespace Modules\CoreCRM\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\BaseCore\Contracts\Entities\UserEntity;
use Modules\CoreCRM\Models\Source;
use Modules\BaseCore\Models\User;

class SourcePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the source can views any models.
     *
     * @param  Modules\BaseCore\Models\User  $user
     * @return mixed
     */
    public function viewAny(UserEntity $user)
    {
        return $user->hasPermissionTo('list sources');
    }

    /**
     * Determine whether the source can views the model.
     *
     * @param  Modules\BaseCore\Models\User  $user
     * @param  Modules\CoreCRM\Models\Source  $model
     * @return mixed
     */
    public function view(UserEntity $user, Source $model)
    {
        return $user->hasPermissionTo('views sources');
    }

    /**
     * Determine whether the source can create models.
     *
     * @param  Modules\BaseCore\Models\User  $user
     * @return mixed
     */
    public function create(UserEntity $user)
    {
        return $user->hasPermissionTo('create sources');
    }

    /**
     * Determine whether the source can update the model.
     *
     * @param  Modules\BaseCore\Models\User  $user
     * @param  Modules\CoreCRM\Models\Source  $model
     * @return mixed
     */
    public function update(UserEntity $user, Source $model)
    {
        return $user->hasPermissionTo('update sources');
    }

    /**
     * Determine whether the source can delete the model.
     *
     * @param  Modules\BaseCore\Models\User  $user
     * @param  Modules\CoreCRM\Models\Source  $model
     * @return mixed
     */
    public function delete(UserEntity $user, Source $model)
    {
        return $user->hasPermissionTo('delete sources');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  Modules\BaseCore\Models\User  $user
     * @param  Modules\CoreCRM\Models\Source  $model
     * @return mixed
     */
    public function deleteAny(UserEntity $user)
    {
        return $user->hasPermissionTo('delete sources');
    }

    /**
     * Determine whether the source can restore the model.
     *
     * @param  Modules\BaseCore\Models\User  $user
     * @param  Modules\CoreCRM\Models\Source  $model
     * @return mixed
     */
    public function restore(UserEntity $user, Source $model)
    {
        return false;
    }

    /**
     * Determine whether the source can permanently delete the model.
     *
     * @param  Modules\BaseCore\Models\User  $user
     * @param  Modules\CoreCRM\Models\Source  $model
     * @return mixed
     */
    public function forceDelete(UserEntity $user, Source $model)
    {
        return false;
    }
}
