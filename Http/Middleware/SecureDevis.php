<?php

namespace Modules\CoreCRM\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Modules\CoreCRM\Actions\Devis\GenerateKeyDevis;
use Modules\CoreCRM\Contracts\Repositories\DevisRepositoryContract;

class SecureDevis
{
    /**
     * Handle the incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $repDevis = app(DevisRepositoryContract::class);

        $token = $request->route('token');
        $devis = $request->route('devis');

        $devi = $repDevis->fetchById($devis->id ?? $devis);

        $carbonTransfert = Carbon::createFromFormat('Y-m-d', "2022-07-15");
        if($carbonTransfert->lessThan($devi->created_at)) {
            $key = (new GenerateKeyDevis())->GenerateKey($devi);

            if ($key !== $token) {
                return response()->view('basecore::errors.401', ['slot' => ''], 401);
            }
        }

        return $next($request);
    }

}
