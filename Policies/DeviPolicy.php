<?php

namespace Modules\CoreCRM\Policies;

use Modules\CoreCRM\Contracts\Entities\DevisEntities;
use Modules\CoreCRM\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DeviPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the devi can views any models.
     *
     * @param  Modules\CoreCRM\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list devis');
    }

    /**
     * Determine whether the devi can views the model.
     *
     * @param  Modules\CoreCRM\Models\User  $user
     * @param  Modules\CoreCRM\Contracts\Entities\DevisEntities  $model
     * @return mixed
     */
    public function view(User $user, DevisEntities $model = null)
    {
        return $user->hasPermissionTo('views devis');
    }

    /**
     * Determine whether the devi can create models.
     *
     * @param  Modules\CoreCRM\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create devis');
    }

    /**
     * Determine whether the devi can update the model.
     *
     * @param  Modules\CoreCRM\Models\User  $user
     * @param  Modules\CoreCRM\Contracts\Entities\DevisEntities  $model
     * @return mixed
     */
    public function update(User $user, DevisEntities $model = null)
    {
        return $user->hasPermissionTo('update devis');
    }

    /**
     * Determine whether the devi can delete the model.
     *
     * @param  Modules\CoreCRM\Models\User  $user
     * @param  Modules\CoreCRM\Contracts\Entities\DevisEntities  $model
     * @return mixed
     */
    public function delete(User $user, DevisEntities $model = null)
    {
        return $user->hasPermissionTo('delete devis');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  Modules\CoreCRM\Models\User  $user
     * @param  Modules\CoreCRM\Contracts\Entities\DevisEntities  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete devis');
    }

    /**
     * Determine whether the devi can restore the model.
     *
     * @param  Modules\CoreCRM\Models\User  $user
     * @param  Modules\CoreCRM\Contracts\Entities\DevisEntities  $model
     * @return mixed
     */
    public function restore(User $user, DevisEntities $model = null)
    {
        return false;
    }

    /**
     * Determine whether the devi can permanently delete the model.
     *
     * @param  Modules\CoreCRM\Models\User  $user
     * @param  Modules\CoreCRM\Contracts\Entities\DevisEntities  $model
     * @return mixed
     */
    public function forceDelete(User $user, DevisEntities $model = null)
    {
        return false;
    }
}
