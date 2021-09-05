<?php

namespace Modules\CoreCRM\Http\Middleware;

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

        $key = (new GenerateKeyDevis())->GenerateKey($devi);

        if ($key !== $token) {
            return response()->view('errors.401', ['slot' => ''], 401);
        }

        return $next($request);
    }

}
