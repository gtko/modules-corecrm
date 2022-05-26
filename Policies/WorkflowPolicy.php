<?php

namespace Modules\CoreCRM\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\BaseCore\Contracts\Entities\UserEntity;
use Modules\CoreCRM\Models\Workflow;

class WorkflowPolicy
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
        return $user->hasPermissionTo('list workflows');
    }

    /**
     * Determine whether the status can views the model.
     *
     * @param  Modules\BaseCore\Models\User  $user
     * @param  Modules\CoreCRM\Models\Workflow  $model
     * @return mixed
     */
    public function view(UserEntity $user, Workflow $model)
    {
        return $user->hasPermissionTo('views workflows');
    }

    /**
     * Determine whether the status can create models.
     *
     * @param  Modules\BaseCore\Models\User  $user
     * @return mixed
     */
    public function create(UserEntity $user)
    {
        return $user->hasPermissionTo('create workflows');
    }

    /**
     * Determine whether the status can update the model.
     *
     * @param  Modules\BaseCore\Models\User  $user
     * @param  Modules\CoreCRM\Models\Workflow  $model
     * @return mixed
     */
    public function update(UserEntity $user, Workflow $model)
    {
        return $user->hasPermissionTo('update workflows');
    }

    /**
     * Determine whether the status can delete the model.
     *
     * @param  Modules\BaseCore\Models\User  $user
     * @param  Modules\CoreCRM\Models\Workflow  $model
     * @return mixed
     */
    public function delete(UserEntity $user, Workflow $model)
    {
        return $user->hasPermissionTo('delete workflows');
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
        return $user->hasPermissionTo('delete workflows');
    }

    /**
     * Determine whether the status can restore the model.
     *
     * @param  Modules\BaseCore\Models\User  $user
     * @param  Modules\CoreCRM\Models\Workflow  $model
     * @return mixed
     */
    public function restore(UserEntity $user, Workflow $model)
    {
        return false;
    }

    /**
     * Determine whether the status can permanently delete the model.
     *
     * @param  Modules\BaseCore\Models\User  $user
     * @param  Modules\CoreCRM\Models\Workflow  $model
     * @return mixed
     */
    public function forceDelete(UserEntity $user, Workflow $model)
    {
        return false;
    }
}
