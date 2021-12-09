<?php

namespace Modules\CoreCRM\Mail;

use Illuminate\Mail\Mailable;
use Modules\CoreCRM\Flow\Works\Events\WorkFlowEvent;

class WorkFlowStandardMail extends Mailable
{

    public function __construct(public string $sujet, public string $emailsSupplementaire, public string $content, public array $files = [])
    {}

    public function build()
    {
        $mail =  $this->markdown('corecrm::emails.work-flow-standard', [
            'content' => $this->content
        ]);

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
