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

    public array $follow_ids = [];

    public function mount(ClientEntity $client, Dossier $dossier){
        $this->dossier = $dossier;
        $this->client = $client;
        $this->follow_ids = $this->dossier->followers->pluck('id')->toArray();
    }

    public function updated(){
        $this->dossier->followers()->sync($this->follow_ids);
        app(FlowContract::class)->add($this->dossier, (new ClientDossierFollowChange(Auth::user(), $this->dossier->followers()->get())));
    }

    public function render()
    {
        $users = app(UserRepositoryContract::class)->all()->where('id', '!=', $this->dossier->commercial_id);
        return view('corecrm::livewire.follower-dossier', compact('users'));
    }
}
