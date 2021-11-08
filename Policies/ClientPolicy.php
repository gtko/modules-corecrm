<?php

namespace Modules\CoreCRM\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\BaseCore\Contracts\Entities\UserEntity;
use Modules\CoreCRM\Contracts\Entities\ClientEntity;
use Modules\CoreCRM\Models\Client;
use Modules\BaseCore\Models\User;

class ClientPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the client can views any models.
     *
     * @param \Modules\BaseCore\Contracts\Entities\UserEntity $user
     * @return bool
     */
    public function viewAny(UserEntity $user)
    {
        return $user->hasPermissionTo('list clients');
    }

    /**
     * Determine whether the client can views the model.
     *
     * @param \Modules\BaseCore\Contracts\Entities\UserEntity $user
     * @return bool
     */
    public function view(UserEntity $user)
    {
        return $user->hasPermissionTo('views clients');
    }

    /**
     * Determine whether the client can create models.
     *
     * @param \Modules\BaseCore\Contracts\Entities\UserEntity $user
     * @return bool
     */
    public function create(UserEntity $user)
    {
        return $user->hasPermissionTo('create clients');
    }

    /**
     * Determine whether the client can update the model.
     *
     * @param \Modules\BaseCore\Contracts\Entities\UserEntity $user
     * @param \Modules\CoreCRM\Models\Client $model
     * @return bool
     */
    public function update(UserEntity $user, ClientEntity $model = null)
    {
        return $user->hasPermissionTo('update clients');
    }

    /**
     * Determine whether the client can delete the model.
     *
     * @param \Modules\BaseCore\Contracts\Entities\UserEntity $user
     * @param \Modules\CoreCRM\Contracts\Entities\ClientEntity $model
     * @return bool
     */
    public function delete(UserEntity $user, ClientEntity $model)
    {
        return $user->hasPermissionTo('delete clients');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param \Modules\BaseCore\Contracts\Entities\UserEntity $user
     * @return bool
     */
    public function deleteAny(UserEntity $user)
    {
        return $user->hasPermissionTo('delete clients');
    }

    /**
     * Determine whether the client can restore the model.
     *
     * @param \Modules\BaseCore\Contracts\Entities\UserEntity $user
     * @param \Modules\CoreCRM\Contracts\Entities\ClientEntity $model
     * @return false
     */
    public function restore(UserEntity $user, ClientEntity $model)
    {
        return false;
    }

    /**
     * Determine whether the client can permanently delete the model.
     *
     * @param \Modules\BaseCore\Contracts\Entities\UserEntity $user
     * @param \Modules\CoreCRM\Contracts\Entities\ClientEntity $model
     * @return false
     */
    public function forceDelete(UserEntity $user, ClientEntity $model)
    {
        return false;
    }
}
