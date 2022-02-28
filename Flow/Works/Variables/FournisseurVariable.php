<?php

namespace Modules\CoreCRM\Flow\Works\Variables;

use Illuminate\Support\Carbon;
use Modules\CoreCRM\Models\Fournisseur;

class FournisseurVariable extends WorkFlowVariable
{

    public $trajet = [];
    public $data = [];

    public function namespace(): string
    {
        return 'fournisseur';
    }

    public function data(array $params = []): array
    {
        /**  @var Fournisseur $fournisseur */

        $fournisseur = $this->event->getData()['fournisseur'];


        return [
            'id' => $fournisseur->id,
            'full name' => $fournisseur->format_name,
            'email' => $fournisseur->email,
            'phone' => $fournisseur->phone,
            'commentaire' => '',
            'details' => $this->detailHtml(),
        ];
    }


    protected function commentaireHtml()
    {
        $this->data = $this->event->getData()['devis']->data;
        $this->trajet = $this->data['trajets'][0] ?? [];
        if ($this->trajet['commentaire'] ?? false){
            return <<<mark
<div>
   <h2>Commentaire</h2>
   <p style="color:#4d4d4d;">{$this->trajet['commentaire']}</p>
</div>
mark;
        }
        return '';
    }

    protected function detailHtml(){
        $this->data = $this->event->getData()['devis']->data;
        $this->trajet = $this->data['trajets'][0] ?? false;
        if($this->trajet) {
            $date = Carbon::parse($this->trajet['aller_date_depart']);
            $detail = <<<mark
<div>
   <h2>Aller</h2>
   Départ de <strong>{$this->trajet['aller_point_depart']}</strong> vers {$this->trajet['aller_point_arriver']}<br>
   Date : {$date->format('d/m/Y')} <br>
   Heure de Départ : {$date->format('H:i')} <br>
   Nombre de passager : {$this->trajet['aller_pax']}<br><br>
</div>
mark;

            if ($this->trajet['retour_point_depart']) {
                $retour_date = \Carbon\Carbon::parse($this->trajet['retour_date_depart']);
                $detail .= <<<mark
                <div>
                   <h2>Retour</h2>
                   Retour de vers {$retour_date->format('m/d/Y')}<br>
                   Départ de  <strong>{$this->trajet['retour_point_depart']}</strong> vers {$this->trajet['retour_point_arriver']}<br>
                   Heure de Départ : {$date->format('H:i')} <br>
                   Nombre de passager : {$this->trajet['retour_pax']}<br><br>
                </div>
            mark;
            }

            $detail .= <<<mark
            <div>
                <h2> Informations complémentaires</h2>
                Nombre de conducteur(s) : {$this->data['nombre_chauffeur']} <br><br>
            </div>
        mark;


            return $detail;
        }

        return '';
    }

    public function labels(): array
    {
        return [
            'id' => 'id du fournisseur',
            'full name' => 'Nom et prénom du fournisseur',
            'email' => 'Email du fournisseur',
            'phone' => 'Numéro de téléphone du fournisseur',
            'détails' => 'Détails du trajet',
            'commentaire' => '',

        ];
    }
}
