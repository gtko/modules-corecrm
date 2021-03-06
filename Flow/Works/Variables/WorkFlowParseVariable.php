<?php

namespace Modules\CoreCRM\Flow\Works\Variables;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Str;
use Modules\CoreCRM\Flow\Works\Events\WorkFlowEvent;

class WorkFlowParseVariable
{

    public WorkFlowEvent $event;
    public array $datas;
    public array $options = [
        'convert_link_to_button' => true,
    ];

    public function __construct(WorkFlowEvent $event, array $datas){

        $this->event = $event;
        $this->datas = $datas;

    }

    public function desactiveConvertLinkToButton(){
        $this->options['convert_link_to_button'] = false;
        return $this;
    }

    public function activeConvertLinkToButton(){
        $this->options['convert_link_to_button'] = true;
        return $this;
    }

    /**
     * @param array $options
     * @return $this
     */
    public function setOptions(array $options){
        $this->options = $options;
        return $this;
    }


    public function resolve():array
    {
        $response = [];
        foreach($this->datas as $name => $data){
            if(is_string($data)) {
                $text = $data;

                preg_match_all("#\{([^{}]+)\}#", $text, $result);

                foreach(($result[1] ?? []) as $index => $key){
                    $params = explode('|', $key);

                    $params = array_map(function ($item) {
                        return trim($item);
                    }, $params);

                    $variableStr = explode('.', $params[0]);
                    $parameters = array_slice($params, 1);
                    foreach ($this->event->variables() as $variable){
                        if($variableStr[0] === $variable->namespace()){
                            $data = $variable->data($parameters);
                            foreach($data as $nameData => $value) {
                                if(Str::lower(Str::slug($nameData)) === $variableStr[1]){
                                    $text = str_replace($result[0][$index], $this->formatData($value, $variableStr[0], $parameters), $text);
                                }
                            }
                        }
                    }
                }

                $response[$name] = trim($text);
            }else{
                $response[$name] = $data;
            }
        }

        return $response;
    }

    public function formatData($value, $namespace, $parameters = [])
    {
        if($this->options['convert_link_to_button']) {
            //on traite un lien en boutton
            if (Str::contains($value, '://')) {
                $label = ($parameters[0] ?? false) ? $parameters[0] : "Voir $namespace";

                if ($label !== 'text') {

                    $component = <<<mark
               <table width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; position: relative;"><tbody><tr>
                <td align="center" style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; position: relative;">
                <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; position: relative;"><tbody><tr>
                <td style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; position: relative;">
                <a target="_blank" rel="noopener noreferrer" href="$value" class="button button-success" style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; position: relative; -webkit-text-size-adjust: none; border-radius: 4px; color: #fff; display: inline-block; overflow: hidden; text-decoration: none; background-color: #48bb78; border-bottom: 8px solid #48bb78; border-left: 18px solid #48bb78; border-right: 18px solid #48bb78; border-top: 8px solid #48bb78;">
                   $label
                </a>
                </td>
                </tr></tbody></table>
                </td>
                </tr></tbody></table>
            mark;
                    return $component;
                }
            }

            //on ajoute un prefix
            if (isset($label) && $label !== 'text') {
                $value = ($parameters[0] ?? false) ? $parameters[0] . ' ' . $value : $value;
            }
        }

        return $value;
    }



}
