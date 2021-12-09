<?php

namespace Modules\CoreCRM\Mail;

use Illuminate\Mail\Mailable;

class WorkFlowStandardMail extends Mailable
{



    public function __construct(public string $sujet, public string $emailsSupplementaire, public string $content)
    {

    }

    public function build()
    {
        $mail =  $this->markdown('corecrm::emails.work-flow-standard', [
            'content' => $this->content
        ]);

        if(!empty($this->emailsSupplementaire)) {
            $emails = explode(',', $this->emailsSupplementaire);
            $mail->cc($emails);
        }

        return $mail->subject($this->sujet);
    }
}
