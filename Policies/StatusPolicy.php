<?php

namespace Modules\CoreCRM\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\CoreCRM\Models\Status;
use Modules\BaseCore\Models\User;

class StatusPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the status can views any models.
     *
     * @param  Modules\BaseCore\Models\User  $user
     * @return mixed
     */
    public function viewAny(UserEntity $user)
    {
        return $user->hasPermissionTo('list statuses');
    }

    /**
     * Determine whether the status can views the model.
     *
     * @param  Modules\BaseCore\Models\User  $user
     * @param  Modules\CoreCRM\Models\Status  $model
     * @return mixed
     */
    public function view(UserEntity $user, Status $model)
    {
        return $user->hasPermissionTo('views statuses');
    }

    /**
     * Determine whether the status can create models.
     *
     * @param  Modules\BaseCore\Models\User  $user
     * @return mixed
     */
    public function create(UserEntity $user)
    {
        return $user->hasPermissionTo('create statuses');
    }

    /**
     * Determine whether the status can update the model.
     *
     * @param  Modules\BaseCore\Models\User  $user
     * @param  Modules\CoreCRM\Models\Status  $model
     * @return mixed
     */
    public function update(UserEntity $user, Status $model)
    {
        return $user->hasPermissionTo('update statuses');
    }

    /**
     * Determine whether the status can delete the model.
     *
     * @param  Modules\BaseCore\Models\User  $user
     * @param  Modules\CoreCRM\Models\Status  $model
     * @return mixed
     */
    public function delete(UserEntity $user, Status $model)
    {
        return $user->hasPermissionTo('delete statuses');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  Modules\BaseCore\Models\User  $user
     * @param  Modules\CoreCRM\Models\Status  $model
     * @return mixed
     */
    public function deleteAny(UserEntity $user)
    {
        return $user->hasPermissionTo('delete statuses');
    }

    /**
     * Determine whether the status can restore the model.
     *
     * @param  Modules\BaseCore\Models\User  $user
     * @param  Modules\CoreCRM\Models\Status  $model
     * @return mixed
     */
    public function restore(UserEntity $user, Status $model)
    {
        return false;
    }

    /**
     * Determine whether the status can permanently delete the model.
     *
     * @param  Modules\BaseCore\Models\User  $user
     * @param  Modules\CoreCRM\Models\Status  $model
     * @return mixed
     */
    public function forceDelete(UserEntity $user, Status $model)
    {
        return false;
    }
}
