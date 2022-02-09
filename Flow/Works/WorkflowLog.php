<?php

namespace Modules\CoreCRM\Flow\Works;

class WorkflowLog
{

    public function info(...$messages){
        foreach($messages as $message){
            //@todo enregistrer dans la bdd sur un run
        }
    }

    public function error(...$messages){
        foreach($messages as $message){
            //@todo enregistrer dans la bdd sur un run
        }
    }

    public function dump(...$dumps){
        foreach($dumps as $dump){
            //@todo enregistrer dans la bdd sur un run
        }
    }

}
