<?php


namespace Modules\CoreCRM\Services;


use Illuminate\Auth\SessionGuard;
use Modules\BaseCore\Exceptions\BadRoleDefinedException;
use Modules\CoreCRM\Models\Commercial;

class GuardCRM extends SessionGuard
{

    /**
     * @throws \Modules\BaseCore\Exceptions\BadRoleDefinedException
     */
    public function commercial():Commercial
    {
        $user = $this->user();

        if($user) {
            if ($user->hasRole('commercial') || $user->isSuperAdmin()) {
                return Commercial::find($user->id);
            }

            throw new BadRoleDefinedException("Le role commercial n'est pas attribué a cet utilisateur");
        }
    }

}
