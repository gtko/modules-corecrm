<?php


namespace Modules\CoreCRM\Actions\Devis;

use Modules\CoreCRM\Contracts\Entities\DevisEntities;

class GenerateKeyDevis
{

    public function GenerateKey(DevisEntities $devi):string
    {
        return md5($devi->id . config('app.key'));

    }

}
