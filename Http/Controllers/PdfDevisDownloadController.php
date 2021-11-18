<?php

namespace Modules\CoreCRM\Http\Controllers;

use Illuminate\Support\Str;
use Modules\CoreCRM\Actions\Devis\GenerateLinkDevis;
use Modules\CoreCRM\Contracts\Entities\DevisEntities;
use Modules\BaseCore\Contracts\Services\PdfContract;
use Modules\CrmBe\Librairies\Yousign\YousignApi;

class PdfDevisDownloadController extends Controller
{
    public function download(DevisEntities $devis)
    {

        $pdfService = app(PdfContract::class);
        $pdfService->setUrl((new GenerateLinkDevis())->GenerateLinkPDF($devis));
        $filename = $devis->ref . '-' . Str::slug($devis->dossier->client->format_name) . '-' . $devis->created_at->format('d-m-Y') . '.pdf';

        return $pdfService->downloadPdf($filename);
    }

    public function signed(DevisEntities $devis){
        /*
         * Token
         */
        $token = '2be2e571e2edb78da7f3ffcb7d237972';
        /*
         * Production mode
         */
        $production = false;

        /*
         * Instanciate API wrapper
         */
        $file = $devis->yousign_data['member']['fileObjects'][0]['file']['id'] ?? '';
        if($file) {
            $yousign = new YousignApi($token, $production);
            $download = $yousign->getDownload($file);
            $filename = $devis->ref . '-' . Str::slug($devis->dossier->client->format_name) . '-' . $devis->created_at->format('d-m-Y') . '-signé' . '.pdf';
            return response()->streamDownload(function () use ($download) {
                echo base64_decode($download);
            }, $filename);

        }
    }

}
