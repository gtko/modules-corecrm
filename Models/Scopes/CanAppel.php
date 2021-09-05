<?php

namespace Modules\CoreCRM\Models\Scopes;

use Modules\AppelCRM\Models\Appel;

trait CanAppel
{

    public function appels()
    {
        return $this->hasMany(Appel::class);
    }


}
