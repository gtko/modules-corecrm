<?php

namespace Modules\CoreCRM\Flow\Works\Variables;

use Illuminate\Support\Facades\Blade;
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
            if(is_string($data)) {
                $text = $data;
                foreach ($this->event->variables() as $variable){
                    $namespace = $variable->namespace();
                    foreach ($variable->data() as $key => $value){
                            $nameVariable = Str::lower('{' . $namespace . '.' . Str::slug($key) . '}');
                            $text = str_replace($nameVariable, $this->formatData($value, $namespace), $text);
                    }
                }

                $response[$name] = trim($text);
            }else{
                $response[$name] = $data;
            }
        }

        return $response;
    }

    public function formatData($value, $namespace)
    {
        if(Str::contains($value, '://')) {
            $component = <<<mark
               <table width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; position: relative;"><tbody><tr>
                <td align="center" style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; position: relative;">
                <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; position: relative;"><tbody><tr>
                <td style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; position: relative;">
                <a target="_blank" rel="noopener noreferrer" href="$value" class="button button-success" style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; position: relative; -webkit-text-size-adjust: none; border-radius: 4px; color: #fff; display: inline-block; overflow: hidden; text-decoration: none; background-color: #48bb78; border-bottom: 8px solid #48bb78; border-left: 18px solid #48bb78; border-right: 18px solid #48bb78; border-top: 8px solid #48bb78;">
                Voir $namespace
                </a>
                </td>
                </tr></tbody></table>
                </td>
                </tr></tbody></table>
            mark;
            return $component;
        }

        return $value;
    }



}
