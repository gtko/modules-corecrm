<?php

namespace Modules\CoreCRM\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\CoreCRM\Models\Status;
use Modules\BaseCore\Models\User;

class PipelinePolicy
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
        return $user->hasPermissionTo('list pipelines');
    }

    /**
     * Determine whether the status can views the model.
     *
     * @param  Modules\BaseCore\Models\User  $user
     * @param  Modules\CoreCRM\Models\Pipeline  $model
     * @return mixed
     */
    public function view(UserEntity $user, Pipeline $model)
    {
        return $user->hasPermissionTo('views pipelines');
    }

    /**
     * Determine whether the status can create models.
     *
     * @param  Modules\BaseCore\Models\User  $user
     * @return mixed
     */
    public function create(UserEntity $user)
    {
        return $user->hasPermissionTo('create pipelines');
    }

    /**
     * Determine whether the status can update the model.
     *
     * @param  Modules\BaseCore\Models\User  $user
     * @param  Modules\CoreCRM\Models\Pipeline  $model
     * @return mixed
     */
    public function update(UserEntity $user, Pipeline $model)
    {
        return $user->hasPermissionTo('update pipelines');
    }

    /**
     * Determine whether the status can delete the model.
     *
     * @param  Modules\BaseCore\Models\User  $user
     * @param  Modules\CoreCRM\Models\Pipeline  $model
     * @return mixed
     */
    public function delete(UserEntity $user, Pipeline $model)
    {
        return $user->hasPermissionTo('delete pipelines');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  Modules\BaseCore\Models\User  $user
     * @param  Modules\CoreCRM\Models\Pipeline  $model
     * @return mixed
     */
    public function deleteAny(UserEntity $user)
    {
        return $user->hasPermissionTo('delete pipelines');
    }

    /**
     * Determine whether the status can restore the model.
     *
     * @param  Modules\BaseCore\Models\User  $user
     * @param  Modules\CoreCRM\Models\Pipeline  $model
     * @return mixed
     */
    public function restore(UserEntity $user, Pipeline $model)
    {
        return false;
    }

    /**
     * Determine whether the status can permanently delete the model.
     *
     * @param  Modules\BaseCore\Models\User  $user
     * @param  Modules\CoreCRM\Models\Pipeline  $model
     * @return mixed
     */
    public function forceDelete(UserEntity $user, Pipeline $model)
    {
        return false;
    }
}
