<?php

namespace Modules\CoreCRM\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\BaseCore\Contracts\Entities\UserEntity;
use Modules\CoreCRM\Models\Document;
use Modules\CoreCRM\Models\Source;
use Modules\BaseCore\Models\User;

class DocumentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the source can views any models.
     *
     * @param \Modules\BaseCore\Contracts\Entities\UserEntity $user
     * @return bool
     */
    public function viewAny(UserEntity $user)
    {
        return $user->hasPermissionTo('list documents');
    }

    /**
     * Determine whether the source can views the model.
     *
     * @param \Modules\BaseCore\Contracts\Entities\UserEntity $user
     * @param \Modules\CoreCRM\Models\Document $model
     * @return bool
     */
    public function view(UserEntity $user, Document $model)
    {
        return $user->hasPermissionTo('views documents');
    }

    /**
     * Determine whether the source can create models.
     *
     * @param \Modules\BaseCore\Contracts\Entities\UserEntity $user
     * @return mixed
     */
    public function create(UserEntity $user)
    {
        return $user->hasPermissionTo('create documents');
    }

    /**
     * Determine whether the source can update the model.
     *
     * @param \Modules\BaseCore\Contracts\Entities\UserEntity $user
     * @param \Modules\CoreCRM\Models\Document $model
     * @return bool
     */
    public function update(UserEntity $user, Document $model)
    {
        return $user->hasPermissionTo('update documents');
    }

    /**
     * Determine whether the source can delete the model.
     *
     * @param \Modules\BaseCore\Contracts\Entities\UserEntity $user
     * @param \Modules\CoreCRM\Models\Document $model
     * @return bool
     */
    public function delete(UserEntity $user, Document $model)
    {
        return $user->hasPermissionTo('delete documents');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param \Modules\BaseCore\Contracts\Entities\UserEntity $user
     * @return bool
     */
    public function deleteAny(UserEntity $user)
    {
        return $user->hasPermissionTo('delete documents');
    }

    /**
     * Determine whether the source can restore the model.
     *
     * @param \Modules\BaseCore\Contracts\Entities\UserEntity $user
     * @param \Modules\CoreCRM\Models\Document $model
     * @return false
     */
    public function restore(UserEntity $user, Document $model)
    {
        return false;
    }

    /**
     * Determine whether the source can permanently delete the model.
     *
     * @param \Modules\BaseCore\Contracts\Entities\UserEntity $user
     * @param \Modules\CoreCRM\Models\Document $model
     * @return false
     */
    public function forceDelete(UserEntity $user, Document $model)
    {
        return false;
    }
}
