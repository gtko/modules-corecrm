<?php

namespace Modules\CoreCRM\Flow\Works\Variables;

use Illuminate\Support\Str;
use Modules\CoreCRM\Flow\Works\Events\WorkFlowEvent;

class WorkFlowParseVariable
{

    public WorkFlowEvent $event;
    public array $datas;

    public function __construct(WorkFlowEvent $event, array $datas){

        $this->event = $event;
        $this->datas = $datas;

    }


    public function resolve():array
    {
        $response = [];
        foreach($this->datas as $name => $data){
            $text = $data;
            foreach ($this->event->variables() as $variable){
                $namespace = $variable->namespace();
                foreach ($variable->data() as $key => $value){
                   $nameVariable = Str::lower('{'.$namespace.'.'.Str::slug($key).'}');
                   $text = str_replace($nameVariable, $this->formatData($value, $namespace), $text);
                }
            }

            $response[$name] = trim($text);
        }

        return $response;
    }

    public function formatData($value, $namespace)
    {
        if(Str::contains($value, '://')) {
            return '<a href="' . $value . '">Voir ' . $namespace . '</a>';
        }

        return $value;
    }



}
