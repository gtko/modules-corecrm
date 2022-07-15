<?php

namespace Modules\CoreCRM\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;
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

        $driver = strtolower($this->datas['driver'] ?? 'default');
        $driverService = app(DriversMailService::class);
        $fromName = null;

        if($driver !== 'default') {
            $from = $driverService->from($driver);
            $fromName = $driverService->fromName($driver);
        }else{
           $from = $this->datas['from'] ?? config('mail.from.address');
           $fromName = $this->datas['from_name'] ?? config('mail.from.name');
        }

        $maillable->from($from, $fromName);


        Log::channel('emails')->info('SendNotificationWorkFlowJob: '.$this->event->name() . ' - ' . $from . ' - ' . $fromName);

        $mailer = Mail::mailer($driverService->mailer($driver));
        $mailer->to(trim($this->datas['cc'] ?? 'gtux.prog@gmail.com'))
            ->send(
                $maillable
            );
    }

    public function maillable(){
        $files = [];
        foreach(($this->datas['files'] ?? []) as $file){
            if($file instanceof WorkFlowAttachments){
                $files[] = $file;
                Log::channel('emails')->info('SendNotificationWorkFlowJob sendfile : ' . print_r($file, true));
            }else {
                $class = base64_decode($file['class']);
                Log::channel('emails')->info('SendNotificationWorkFlowJob sendfile : ' . print_r($class, true));
                $files[] = (new $class($this->event));
            }
        }

        return new WorkFlowStandardMail(
            $this->datas['subject'],
            $this->datas['cci'] ?? '',
            $this->datas['content'] ?? '',
            $files,
            $this->datas['template'] ?? 'default',
        );
    }
}
