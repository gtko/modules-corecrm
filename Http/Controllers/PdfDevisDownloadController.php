<?php

namespace Modules\CoreCRM\Http\Controllers;

use Illuminate\Support\Str;
use Modules\CoreCRM\Actions\Devis\GenerateLinkDevis;
use Modules\CoreCRM\Contracts\Entities\DevisEntities;
use Modules\BaseCore\Contracts\Services\PdfContract;

class PdfDevisDownloadController extends Controller
{
    public function download(DevisEntities $devis)
    {

        $pdfService = app(PdfContract::class);
        $pdfService->setUrl((new GenerateLinkDevis())->GenerateLinkPDF($devis));
        $filename = $devis->ref . '-' . Str::slug($devis->dossier->client->format_name) . '-' . $devis->created_at->format('d-m-Y') . '.pdf';

        return $pdfService->downloadPdf($filename);
    }
}
