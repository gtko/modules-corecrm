<?php

namespace Modules\CoreCRM\Flow\Works\Files;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use JsonSerializable;

class WorkFlowAttachments  implements Jsonable, JsonSerializable, Arrayable
{

    protected $content;
    protected $filename;
    protected $mimetype;

    public function __construct($content, $filename, $mimetype){
        $this->content = base64_encode($content);
        $this->filename = $filename;
        $this->mimetype = $mimetype;
    }

    public function name(): string
    {
        return 'Fichier attaché a un email';
    }

    public function description(): string
    {
       return "Permet d'accrocher n'importe quel contenu a un email";
    }

    public function content(): string
    {
        return base64_decode($this->content);
    }

    public function filename(): string
    {
        return $this->filename;
    }

    public function mimetype(): string
    {
        return $this->mimetype;
    }

    public function toJson($options = 0)
    {
        return $this->jsonSerialize();
    }

    /**
     * @throws \JsonException
     */
    public function jsonSerialize()
    {
        return json_encode($this->toArray(), JSON_THROW_ON_ERROR);
    }

    public function toArray()
    {
       return [
           'content' => $this->content,
           'filename' => $this->filename,
           'mimetype' => $this->mimetype
       ];
    }
}
