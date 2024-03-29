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
            'commentaire' => $this->commentaireHtml(),
            'details' => $this->detailHtml(),
        ];
    }


    protected function commentaireHtml()
    {
        $this->data = $this->event->getData()['devis']->data;
        $this->trajet = $this->data['trajets'][0] ?? [];
        if ($this->trajet['commentaire'] ?? false){
            $commentaire = nl2br($this->trajet['commentaire']);
            return <<<mark
<div>
   <h2>Commentaire</h2>
   <p style="color:#4d4d4d;">{$commentaire}</p>
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
                if($this->trajet['retour_date_depart'] ?? false) {
                    $retour_date = \Carbon\Carbon::parse($this->trajet['retour_date_depart']);
                    $format = $retour_date->format('d/m/Y');
                    $format_time = $retour_date->format('H:i');
                }else{
                    $retour_date = "N/A";
                    $format = $retour_date;
                    $format_time = 'N/A';
                }
            }

            if(($this->data['nombre_chauffeur'] ?? false) || ($this->data['nombre_bus'] ?? false)) {

                $chauffeur = 0;
                if(is_array($this->data['nombre_chauffeur'] ?? false)) {
                    $chauffeur = $this->data['nombre_chauffeur'][0];
                }else{
                    $chauffeur = $this->data['nombre_chauffeur'] ?? 0;
                }

                $bus = 0;
                if(is_array($this->data['nombre_bus'] ?? false)) {
                    $bus = $this->data['nombre_bus'][0];
                }else{
                    $bus = $this->data['nombre_bus'] ?? 0;
                }


                $detail .= <<<mark
            <div>
                <h2> Informations complémentaires</h2>
                Nombre de conducteur(s) : $chauffeur <br>
                Nombre d'autocar(s) : $bus <br><br>
            </div>
        mark;
            }


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
            'commentaire' => 'Commentaire du devis',

        ];
    }
}
