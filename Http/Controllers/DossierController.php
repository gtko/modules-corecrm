<?php

namespace Modules\CoreCRM\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\CoreCRM\Contracts\Entities\ClientEntity;
use Modules\CoreCRM\Contracts\Repositories\CommercialRepositoryContract;
use Modules\CoreCRM\Contracts\Repositories\DevisRepositoryContract;
use Modules\CoreCRM\Contracts\Repositories\DossierRepositoryContract;
use Modules\CoreCRM\Contracts\Repositories\SourceRepositoryContract;
use Modules\CoreCRM\Contracts\Repositories\StatusRepositoryContract;
use Modules\CoreCRM\Http\Requests\DossierStoreRequest;
use Modules\CoreCRM\Http\Requests\DossierUpdateRequest;
use Modules\CoreCRM\Models\Client;
use Modules\CoreCRM\Models\Dossier;

class DossierController extends Controller
{


    public function __construct(
        protected DossierRepositoryContract $dossierRep,
        protected StatusRepositoryContract $statusRep,
        protected CommercialRepositoryContract $commercialRep,
        protected SourceRepositoryContract $sourceRep,
        protected DevisRepositoryContract $devisRep,
    ){}


    public function index(){
        return view('corecrm::app.dossiers.index');
    }

    /**
     * @param \Modules\CoreCRM\Contracts\Entities\ClientEntity $client
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create(ClientEntity $client): View|Factory|Application
    {
        $this->authorize('create', Dossier::class);

        $commercials = $this->commercialRep->all();
        $status = $this->statusRep->all();

        return view(
            'corecrm::app.dossiers.create',
            compact( 'client', 'commercials', 'status')
        );
    }

    /**
     * @param \Modules\CoreCRM\Http\Requests\DossierStoreRequest $request
     * @param \Modules\CoreCRM\Contracts\Entities\ClientEntity $client
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(DossierStoreRequest $request, ClientEntity $client,)
    {
        $this->authorize('create', Dossier::class);

        DB::transaction(function() use ($request, $client){
            $commercial = $this->commercialRep->getById($request->commercial_id);
            $status = $this->statusRep->getById($request->status_id);
            $source = $this->sourceRep->getByLabel('CRM');

            $this->dossierRep->create($client, $commercial, $source, $status);
        });

        return redirect()
            ->route('clients.show', $client)
            ->withSuccess(__('basecore::crud.common.created'));
    }

    /**
     * @param \Modules\CoreCRM\Contracts\Entities\ClientEntity $client
     * @param \Modules\CoreCRM\Models\Dossier $dossier
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Request $request, ClientEntity $client, Dossier $dossier): View|Factory|Application
    {
        $this->authorize('view', $dossier);
        $devis = $this->devisRep->getDevisByDossier($dossier);
        $defaultName = $request->get('tab', 'devis');

        return view('corecrm::app.dossiers.show', compact('client', 'dossier', 'devis', 'defaultName'));
    }

    /**
     * @param \Modules\CoreCRM\Contracts\Entities\ClientEntity $client
     * @param \Modules\CoreCRM\Models\Dossier $dossier
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(ClientEntity $client, Dossier $dossier): Application|Factory|View
    {
        $this->authorize('update', $dossier);

        $commercials = $this->commercialRep->all();
        $status = $this->statusRep->all();

        return view(
            'corecrm::app.dossiers.edit',
            compact('dossier', 'client', 'commercials', 'status')
        );
    }

    /**
     * @param \Modules\CoreCRM\Http\Requests\DossierUpdateRequest $request
     * @param \Modules\CoreCRM\Contracts\Entities\ClientEntity $client
     * @param \Modules\CoreCRM\Models\Dossier $dossier
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(DossierUpdateRequest $request, ClientEntity $client, Dossier $dossier)
    {
        $this->authorize('update', $dossier);

        DB::transaction(function () use ($request, $dossier){

            $this->dossierRep->changeCommercial(
                $dossier,
                $this->commercialRep->getById($request->commercial_id)
            );

            $this->dossierRep->changeStatus(
                $dossier,
                $this->statusRep->getById($request->status_id)
            );
        });


        return redirect()
            ->route('dossiers.edit', $dossier)
            ->withSuccess(__('basecore::crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \Modules\CoreCRM\Contracts\Entities\ClientEntity $client
     * @param \Modules\CoreCRM\Models\Dossier $dossier
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Request $request, ClientEntity $client, Dossier $dossier)
    {
        $this->authorize('delete', $dossier);

        $dossier->delete();

        return redirect()
            ->route('corecrm::clients.show', $client)
            ->withSuccess(__('basecore::crud.common.removed'));
    }
}
