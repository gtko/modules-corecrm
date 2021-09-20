<?php

namespace Modules\CoreCRM\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\BaseCore\Contracts\Entities\UserEntity;
use Modules\CoreCRM\Models\Dossier;
use Modules\BaseCore\Models\User;

class DossierPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the dossier can views any models.
     *
     * @param \Modules\CoreCRM\Policies\UserEntity $user
     * @return mixed
     */
    public function viewAny(UserEntity $user)
    {
        return $user->hasPermissionTo('list dossiers');
    }

    /**
     * Determine whether the dossier can views the model.
     *
     * @param  Modules\BaseCore\Models\User  $user
     * @param  Modules\CoreCRM\Models\Dossier  $model
     * @return mixed
     */
    public function view(UserEntity $user, Dossier $model)
    {
        return $user->hasPermissionTo('views dossiers');
    }

    /**
     * Determine whether the dossier can create models.
     *
     * @param  Modules\BaseCore\Models\User  $user
     * @return mixed
     */
    public function create(UserEntity $user)
    {
        return $user->hasPermissionTo('create dossiers');
    }

    /**
     * Determine whether the dossier can update the model.
     *
     * @param  Modules\BaseCore\Models\User  $user
     * @param  Modules\CoreCRM\Models\Dossier  $model
     * @return mixed
     */
    public function update(UserEntity $user, Dossier $model)
    {
        return $user->hasPermissionTo('update dossiers');
    }

    /**
     * Determine whether the dossier can delete the model.
     *
     * @param  Modules\BaseCore\Models\User  $user
     * @param  Modules\CoreCRM\Models\Dossier  $model
     * @return mixed
     */
    public function delete(UserEntity $user, Dossier $model)
    {
        return $user->hasPermissionTo('delete dossiers');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  Modules\BaseCore\Models\User  $user
     * @param  Modules\CoreCRM\Models\Dossier  $model
     * @return mixed
     */
    public function deleteAny(UserEntity $user)
    {
        return $user->hasPermissionTo('delete dossiers');
    }

    /**
     * Determine whether the dossier can restore the model.
     *
     * @param  Modules\BaseCore\Models\User  $user
     * @param  Modules\CoreCRM\Models\Dossier  $model
     * @return mixed
     */
    public function restore(UserEntity $user, Dossier $model)
    {
        return false;
    }

    /**
     * Determine whether the dossier can permanently delete the model.
     *
     * @param  Modules\BaseCore\Models\User  $user
     * @param  Modules\CoreCRM\Models\Dossier  $model
     * @return mixed
     */
    public function forceDelete(UserEntity $user, Dossier $model)
    {
        return false;
    }
}
