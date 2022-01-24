<?php

namespace Modules\CoreCRM\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Modules\CoreCRM\Contracts\Entities\ClientEntity;
use Modules\CoreCRM\Contracts\Entities\DevisEntities;
use Modules\CoreCRM\Models\Client;
use Modules\CoreCRM\Models\Document;
use Modules\CoreCRM\Models\Dossier;
use Modules\CoreCRM\Models\Pipeline;
use Modules\CoreCRM\Models\Source;
use Modules\CoreCRM\Models\Status;
use Modules\CoreCRM\Policies\ClientPolicy;
use Modules\CoreCRM\Policies\DeviPolicy;
use Modules\CoreCRM\Policies\DocumentPolicy;
use Modules\CoreCRM\Policies\DossierPolicy;
use Modules\CoreCRM\Policies\PipelinePolicy;
use Modules\CoreCRM\Policies\SourcePolicy;
use Modules\CoreCRM\Policies\StatusPolicy;
use Modules\CoreCRM\Services\GuardCRM;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        ClientEntity::class => ClientPolicy::class,
        DevisEntities::class => DeviPolicy::class,
        Dossier::class => DossierPolicy::class,
        Source::class => SourcePolicy::class,
        Status::class => StatusPolicy::class,
        Pipeline::class => PipelinePolicy::class,
        Document::class => DocumentPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {

        Auth::extend('corecrm', function ($app, $name, array $config) {
            // Return an instance of Illuminate\Contracts\Auth\Guard...
            $guard = new GuardCRM('crm',
                Auth::createUserProvider($config['provider']),
                $this->app['session.store']
            );
            $guard->setCookieJar(app('cookie'));
            return $guard;
        });

        $this->registerPolicies();
    }
}
