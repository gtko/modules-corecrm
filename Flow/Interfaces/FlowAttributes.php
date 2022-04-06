<?php


namespace Modules\CoreCRM\Flow\Interfaces;




use Modules\CoreCRM\Models\Event;

interface FlowAttributes
{
    public function event():Event;
    public static function instance(array $value):FlowAttributes;
    public function toJson():string;
    public function toArray():array;



    /**
     * @return string Nommage de la clée de l'evenement 'devis.signed', 'dossier.create.devi' ...
     */
    public function getKeyEvent():string;
}
