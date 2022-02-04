<?php

namespace Modules\CoreCRM\Models;

use Rennokki\QueryCache\Traits\QueryCacheable;

class User extends \Modules\BaseCore\Models\User
{


    use QueryCacheable;
//    protected $cacheFor = 3600;

    public function isCommercial():bool
    {
        return $this->hasRole('commercial');
    }

    public function isCommercialOnly():bool
    {
        return $this->hasRole('commercial') && !$this->isSuperAdmin();
    }

}
