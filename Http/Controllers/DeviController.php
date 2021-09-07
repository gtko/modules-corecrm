<?php

namespace Modules\CoreCRM\Http\Controllers;

use App\Http\Requests\DeviUpdateRequest;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\CoreCRM\Contracts\Entities\ClientEntity;
use Modules\CoreCRM\Contracts\Entities\DevisEntities;
use Modules\CoreCRM\Contracts\Repositories\DevisRepositoryContract;
use Modules\CoreCRM\Models\Client;
use Modules\CoreCRM\Models\Dossier;
use Modules\CoreCRM\Models\Fournisseur;

class DeviController extends Controller
{

    /**
     * @param \Modules\CoreCRM\Contracts\Repositories\DevisRepositoryContract $devisRep
     * @param \Modules\CoreCRM\Contracts\Entities\ClientEntity $client
     * @param \Modules\CoreCRM\Models\Dossier $dossier
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create(DevisRepositoryContract $devisRep, ClientEntity $client, Dossier $dossier): RedirectResponse
    {
        $this->authorize('create', DevisEntities::class);

        $devisRep->create($dossier, Auth::commercial());

        return redirect()
            ->route('dossiers.show', [$client, $dossier])
            ->withSuccess(__('basecore::crud.common.created'));
    }

    /**
     * @param \Modules\CoreCRM\Contracts\Entities\ClientEntity $client
     * @param \Modules\CoreCRM\Models\Dossier $dossier
     * @param \Modules\CoreCRM\Contracts\Entities\DevisEntities $devi
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(ClientEntity $client, Dossier $dossier, DevisEntities $devi): View|Factory|Application
    {
        $this->authorize('update', $devi);

        return view('corecrm::app.devis.edit',
            compact('devi',  "client", "dossier")
        );
    }

    /**
     * @param \App\Http\Requests\DeviUpdateRequest $request
     * @param \Modules\CoreCRM\Contracts\Repositories\DevisRepositoryContract $devisRep
     * @param \Modules\CoreCRM\Contracts\Entities\ClientEntity $client
     * @param \Modules\CoreCRM\Models\Dossier $dossier
     * @param \Modules\CoreCRM\Contracts\Entities\DevisEntities $devi
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(DeviUpdateRequest $request,DevisRepositoryContract $devisRep,ClientEntity $client, Dossier $dossier,  DevisEntities $devi): RedirectResponse
    {
        $this->authorize('update', $devi);

        $fournisseur = Fournisseur::find($request->fournisseur_id);
        $devi = $devisRep->updateData($devi, (new DevisDataTypes()));
        $devisRep->updateFournisseur($devi,$fournisseur);

        return redirect()
            ->route('dossiers.show', [$client, $dossier])
            ->withSuccess(__('basecore::crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \Modules\CoreCRM\Contracts\Repositories\DevisRepositoryContract $devisRep
     * @param \Modules\CoreCRM\Contracts\Entities\ClientEntity $client
     * @param \Modules\CoreCRM\Models\Dossier $dossier
     * @param \Modules\CoreCRM\Contracts\Entities\DevisEntities $devi
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Request $request,DevisRepositoryContract $devisRep, ClientEntity $client, Dossier $dossier,  DevisEntities $devi): RedirectResponse
    {
        $this->authorize('delete', $devi);

        $devisRep->delete($devi);

        return redirect()
            ->route('dossiers.show', [$client, $dossier])
            ->withSuccess(__('basecore::crud.common.removed'));
    }
}
