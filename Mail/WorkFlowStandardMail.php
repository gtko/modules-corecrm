<?php

namespace Modules\CoreCRM\Mail;

use Illuminate\Mail\Mailable;

class WorkFlowStandardMail extends Mailable
{



    public function __construct(public string $sujet, public array $emailsSupplementaire, public string $content)
    {

    }

    public function build()
    {
        $mail =  $this->markdown('corecrm::emails.work-flow-standard', [
            'content' => $this->content
        ]);

//        if(count($this->emailsSupplementaire) > 0) {
//            $mail->cc($this->emailsSupplementaire);
//        }

        return $mail->subject($this->sujet);
    }
}
