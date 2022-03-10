<?php

namespace Modules\CoreCRM\Flow\Works\Services;

use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Support\Facades\Mail;

class DriversMailService
{

    protected array $drivers = [];
    protected array $config = [];

    public function add($name, $configName, array $override = []){
        $this->drivers[$name] = array_merge(config('mail.mailers.'.$configName, []), $override);
        $this->config[$name] = $configName;

        return $this;
    }

    public function get($name){
        return $this->drivers[$name];
    }

    public function all(){
        return $this->drivers;
    }

    public function from($name){
        return $this->get($name)['from']['address'] ?? null;
    }

    public function fromName($name){
        return $this->get($name)['from']['name'] ?? null;
    }

    public function mailer($name): Mailer
    {
       return $this->config[$name] ?? config('mail.default');
    }

}
