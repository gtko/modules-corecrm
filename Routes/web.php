<?php


use Illuminate\Support\Facades\Route;
use Modules\CoreCRM\Http\Controllers\ClientController;
use Modules\CoreCRM\Http\Controllers\CommercialController;
use Modules\CoreCRM\Http\Controllers\DeviController;
use Modules\CoreCRM\Http\Controllers\DossierController;
use Modules\CoreCRM\Http\Controllers\FournisseurController;
use Modules\CoreCRM\Http\Controllers\PdfDevisDownloadController;
use Modules\CoreCRM\Http\Controllers\SourceController;
use Modules\CoreCRM\Http\Controllers\StatusController;
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
        Route::resource('statuses', StatusController::class);
        Route::resource('sources', SourceController::class);
        Route::resource('devis', DeviController::class);

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
        Route::get('clients/{client}/dossiers/{dossier}', [DossierController::class,'show'])->name('dossiers.show');
        //Route::resource('clients/{client}/dossiers/{dossier}', DossierController::class)->except('index');
        Route::resource('clients/{client}/dossiers/{dossier}/devis', DeviController::class)->except('index');

        Route::get('pdf/devis/{devis}', [ PdfDevisDownloadController::class, 'download'])->name('pdf-devis-download');
    });
