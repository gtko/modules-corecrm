<?php


namespace Modules\CoreCRM\Actions\Devis;

use Modules\CoreCRM\Contracts\Entities\DevisEntities;

class GenerateLinkDevis
{

    public function GenerateLink(DevisEntities $devi):string
    {
        $key = (new GenerateKeyDevis())->GenerateKey($devi);

        return route('devis-view', [$devi->id , $key]);
    }

    public function GenerateLinkPDF(DevisEntities $devi):string
    {
        $key = (new GenerateKeyDevis())->GenerateKey($devi);

        return route('devis-pdf', [$devi->id , $key]);
    }

}
