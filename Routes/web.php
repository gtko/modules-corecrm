<?php


use Illuminate\Support\Facades\Route;
use Modules\CoreCRM\Http\Controllers\ClientController;
use Modules\CoreCRM\Http\Controllers\CommercialController;
use Modules\CoreCRM\Http\Controllers\DeviController;
use Modules\CoreCRM\Http\Controllers\DossierController;
use Modules\CoreCRM\Http\Controllers\FournisseurController;
use Modules\CoreCRM\Http\Controllers\PdfDevisDownloadController;
use Modules\CoreCRM\Http\Controllers\PipelinesController;
use Modules\CoreCRM\Http\Controllers\SourceController;
use Modules\CoreCRM\Http\Controllers\StatusController;
use Modules\CoreCRM\Http\Controllers\WorkflowLogController;
use Modules\CoreCRM\Http\Controllers\WorkflowsController;
use Modules\CrmAutoCar\Http\Controllers\VuePlateauController;


Route::prefix('/')
    ->middleware(['auth:web', 'verified'])
    ->group(function () {

        Route::middleware(['auth:web', 'verified'])
            ->get('/dashboard', function () {
                return view('corecrm::dashboard');
            })
            ->name('dashboard');

        Route::resource('fournisseurs', FournisseurController::class)->except('show');
        Route::resource('clients', ClientController::class);
        Route::resource('statuses', StatusController::class)->except('show');
        Route::resource('sources', SourceController::class)->except('show');
        Route::resource('devis', DeviController::class);
        Route::resource('pipelines', PipelinesController::class)->except('show');
        Route::resource('workflows', WorkflowsController::class)->except('show', 'store', 'update');
        Route::get('workflows/log', [WorkflowLogController::class, 'index'])->name('workflow-log.index');
        Route::get('workflows/{workflow}/simulate', [WorkflowsController::class, 'simulate'])->name('workflows.simulate');

        Route::middleware(['secure.devis'])->group(function () {
            Route::get('/devis/{devis}/{token}', function(){
                return 'Aucun module qui gère le devi view';
            })->name('devis-view');
            Route::get('/devis/pdf/{devis}/{token}', function(){
                return "Aucun module qui gère l'export pdf";
            })->name('devis-pdf');
        });

        Route::resource('commercials', CommercialController::class)->except('show');
        Route::get('dossiers', [DossierController::class,'index'])->name('dossiers.index');
        Route::get('dossiers/create', [DossierController::class,'create'])->name('dossiers.create');
        Route::get('dossiers/edit/{dossier}', [DossierController::class,'edit'])->name('dossiers.edit');
        Route::get('clients/{client}/dossiers/{dossier}', [DossierController::class,'show'])->name('dossiers.show');
        Route::resource('clients/{client}/dossiers/{dossier}/devis', DeviController::class)->except('index');

        Route::get('pdf/devis/{devis}', [ PdfDevisDownloadController::class, 'download'])->name('pdf-devis-download');

    });
