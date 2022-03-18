<?php

namespace Modules\CoreCRM\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Modules\BaseCore\Contracts\Repositories\UserRepositoryContract;
use Modules\CoreCRM\Contracts\Entities\ClientEntity;
use Modules\CoreCRM\Contracts\Services\FlowContract;
use Modules\CoreCRM\Flow\Attributes\ClientDossierFollowChange;
use Modules\CoreCRM\Models\Dossier;

class FollowerDossier extends Component
{
    public $dossier;
    public $client;
    public $label;
    public $tomselect;
    public array $roles;

    public $follow_ids;

    public function mount(ClientEntity $client, Dossier $dossier, $label = true, array $roles = [], $tomselect = false){
        $this->dossier = $dossier;
        $this->client = $client;
        $this->label = $label;
        $this->roles = $roles;
        $this->tomselect = $tomselect;
        $this->follow_ids = $this->dossier->followers->pluck('id')->toArray();
    }

    public function updated(){
        $this->dossier->followers()->detach();
        if(is_array($this->follow_ids)){
            $this->dossier->followers()->attach($this->follow_ids);
        }else{
            if($this->follow_ids > 0) {
                $this->dossier->followers()->attach([$this->follow_ids]);
            }
        }

        app(FlowContract::class)->add($this->dossier, (new ClientDossierFollowChange(Auth::user(), $this->dossier->followers()->get())));
    }

    public function render()
    {
        $query = app(UserRepositoryContract::class)->newQuery();

        if(!empty($this->roles)){
            $query->whereHas('roles', function($q) {
                $q->whereIn('id', $this->roles);
            });
        }

        $users = $query->get()->where('id', '!=', $this->dossier->commercial_id);

        return view('corecrm::livewire.follower-dossier', compact('users'));
    }
}
