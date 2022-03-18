<?php

namespace Modules\CoreCRM\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;
use Modules\CoreCRM\Flow\Works\Events\WorkFlowEvent;
use Modules\CoreCRM\Flow\Works\Files\WorkFlowAttachments;
use Modules\CoreCRM\Flow\Works\Services\DriversMailService;
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

        $driver = $this->datas['driver'] ?? 'default';
        $driverService = app(DriversMailService::class);
        if($driver !== 'default') {
            //dd($driverService->from($driver), $driverService->fromName($driver));
            $maillable->from($driverService->from($driver), $driverService->fromName($driver));
        }else{
           // dd($this->datas['from'] ?? 'noreply@crm.com');
            $maillable
                ->from($this->datas['from'] ?? 'noreply@crm.com');
        }

        $mailer = Mail::mailer($driverService->mailer($driver));
        $mailer->to($this->datas['cc'])
            ->send(
                $maillable
            );
    }

    public function maillable(){
        $files = [];
        foreach(($this->datas['files'] ?? []) as $file){
            if($file instanceof WorkFlowAttachments){
                $files[] = $file;
            }else {
                $class = base64_decode($file['class']);
                $files[] = (new $class($this->event));
            }
        }

        return new WorkFlowStandardMail(
            $this->datas['subject'],
            $this->datas['cci'] ?? '',
            $this->datas['content'],
            $files,
            $this->datas['template'] ?? 'default',
        );
    }
}
