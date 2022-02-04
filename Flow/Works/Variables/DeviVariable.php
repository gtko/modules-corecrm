<?php

namespace Modules\CoreCRM\Flow\Works\Variables;



use Modules\CoreCRM\Actions\Devis\GenerateLinkDevis;
use Modules\DevisAutoCar\Models\Devi;

class DeviVariable extends WorkFlowVariable
{

    public function namespace(): string
    {
        return 'devi';
    }

    public function data(array $params = []): array
    {
        /**  @var Devi $devis */
        $devi = $this->event->getData()['devis'];

        return [
          'ref' => $devi->ref,
          'lien crm' => route('devis.edit', [$devi->dossier->client, $devi->dossier, $devi]),
          'lien public' => (new GenerateLinkDevis())->GenerateLink($devi),
          'lien pdf' => route('pdf-devis-download',[$devi]),
          'date départ' => $devi->date_depart->format('d/m/Y'),
          'date retour' => $devi->date_retour->format('d/m/Y'),
        ];
    }

    public function labels(): array
    {
        return [
            'ref' => 'Réfèrence du devis',
            'lien crm' => 'Lien pour aller sur le devis dans le CRM',
            'lien public' => 'Lien pour aller sur le devis en version web',
            'lien pdf' => 'Lien pour télécharger le devis en PDF',
            'date départ' => 'La plus petite date de départ du devis',
            'date retour' => 'La plus grande date de retour du devis',
        ];
    }
}
