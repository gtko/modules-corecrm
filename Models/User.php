<?php

namespace Modules\CoreCRM\Models;

class User extends \Modules\BaseCore\Models\User
{

    public function isCommercial():bool
    {
        return $this->hasRole('commercial');
    }

    public function isCommercialOnly():bool
    {
        return $this->hasRole('commercial') && !$this->isSuperAdmin();
    }

}
