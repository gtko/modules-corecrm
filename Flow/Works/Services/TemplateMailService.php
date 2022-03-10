<?php

namespace Modules\CoreCRM\Flow\Works\Services;

class TemplateMailService
{

    const TYPE_MARKDOWN = 'markdown';
    const TYPE_HTML = 'html';
    const TYPE_TEXT = 'text';

    protected array $templates = [
        'default' => [
            "view" => "corecrm::emails.work-flow-standard",
            "type" => self::TYPE_MARKDOWN
        ],
    ];

    public function add($name, $view, $type = 'markdown'){
        $this->templates[$name] = [
            'view' => $view,
            'type' => $type
        ];

        return $this;
    }

    public function get($name){
        return $this->templates[$name];
    }

    public function all(){
        return $this->templates;
    }
}
