<?php

namespace Modules\CoreCRM\Mail;

use Illuminate\Mail\Mailable;
use Modules\CoreCRM\Flow\Works\Events\WorkFlowEvent;
use Modules\CoreCRM\Flow\Works\Services\TemplateMailService;

class WorkFlowStandardMail extends Mailable
{

    public function __construct(
        public string $sujet,
        public string $emailsSupplementaire,
        public string $content,
        public array $files = [],
        public string $template = 'default',
    )
    {}

    public function build()
    {
        $templateService = app(TemplateMailService::class);
        $template = $templateService->get($this->template);

        dump($template);
        $mail = match ($template['type']) {
            TemplateMailService::TYPE_MARKDOWN => $this->markdown($template['view'], [
                'subject' => $this->sujet,
                'content' => $this->content
            ]),
            default => $this->view($template['view'], [
                'subject' => $this->sujet,
                'content' => $this->content
            ]),
        };


        if(!empty($this->emailsSupplementaire)) {
            $emails = explode(',', $this->emailsSupplementaire);
            $mail->cc($emails);
        }

        //gestion des pieces jointe
        foreach($this->files as $file){
            $mail->attachData($file->content(),$file->filename(),
                [
                    'mime' => $file->mimetype(),
                ]
            );
        }

        return $mail->subject($this->sujet);
    }
}
