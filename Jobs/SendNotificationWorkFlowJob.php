<?php

namespace Modules\CoreCRM\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;
use Modules\CoreCRM\Flow\Works\Events\WorkFlowEvent;
use Modules\CoreCRM\Mail\WorkFlowStandardMail;

class SendNotificationWorkFlowJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected array $datas = [];
    protected WorkFlowEvent $event;

    public function __construct(array $data, WorkFlowEvent $event)
    {
        $this->datas = $data;
        $this->event = $event;
    }

    public function handle()
    {
        $maillable = $this->maillable();
        Mail::to($this->datas['cc'])
            ->send(
                $maillable
                ->from($this->datas['from'] ?? 'noreply@crm.com')
            );
    }

    public function maillable(){
        $files = [];
        foreach(($this->datas['files'] ?? []) as $file){
            $class = base64_decode($file['class']);
            $files[] = (new $class($this->event));
        }

        return new WorkFlowStandardMail(
            $this->datas['subject'],
            $this->datas['cci'] ?? '',
            $this->datas['content'],
            $files,
            $this->datas['template'] ?? 'default'
        );
    }
}
