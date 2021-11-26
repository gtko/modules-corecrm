<?php

namespace Modules\CoreCRM\Providers;



use Config;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Modules\BaseCore\Contracts\Entities\UserEntity;
use Modules\BaseCore\Contracts\Services\CompositeurThemeContract;
use Modules\BaseCore\Entities\TypeView;
use Modules\CoreCRM\Contracts\Entities\ClientEntity;
use Modules\CoreCRM\Contracts\Entities\DevisEntities;
use Modules\CoreCRM\Contracts\Repositories\ClientRepositoryContract;
use Modules\CoreCRM\Contracts\Repositories\CommercialRepositoryContract;
use Modules\CoreCRM\Contracts\Repositories\DevisRepositoryContract;
use Modules\CoreCRM\Contracts\Repositories\DossierRepositoryContract;
use Modules\CoreCRM\Contracts\Repositories\EventRepositoryContract;
use Modules\CoreCRM\Contracts\Repositories\FlowRepositoryContract;
use Modules\CoreCRM\Contracts\Repositories\FournisseurRepositoryContract;
use Modules\CoreCRM\Contracts\Repositories\PipelineRepositoryContract;
use Modules\CoreCRM\Contracts\Repositories\SourceRepositoryContract;
use Modules\CoreCRM\Contracts\Repositories\StatusRepositoryContract;
use Modules\CoreCRM\Contracts\Repositories\WorkflowRepositoryContract;
use Modules\CoreCRM\Contracts\Services\FlowContract;
use Modules\CoreCRM\Contracts\Views\DevisEditViewContract;
use Modules\CoreCRM\Flow\Notification\NotificationsDispatch;
use Modules\CoreCRM\Flow\Works\WorkflowKernel;
use Modules\CoreCRM\Models\Client;
use Modules\CoreCRM\Models\Devi;
use Modules\CoreCRM\Models\User;
use Modules\CoreCRM\Repositories\ClientRepository;
use Modules\CoreCRM\Repositories\CommercialRepository;
use Modules\CoreCRM\Repositories\DevisRepository;
use Modules\CoreCRM\Repositories\DossierRepository;
use Modules\CoreCRM\Repositories\EventRepository;
use Modules\CoreCRM\Repositories\FlowRepository;
use Modules\CoreCRM\Repositories\FournisseurRepository;
use Modules\CoreCRM\Repositories\PipelineRepository;
use Modules\CoreCRM\Repositories\SourceRepository;
use Modules\CoreCRM\Repositories\StatusRepository;
use Modules\CoreCRM\Repositories\WorkflowRepository;
use Modules\CoreCRM\Services\FlowCRM;
use Modules\CrmAutoCar\Flow\Works\Events\EventClientDevisExterneConsultation;
use Modules\CrmAutoCar\Flow\Works\Events\EventClientDevisExterneValidation;
use Modules\CrmAutoCar\Flow\Works\Events\EventClientDossierDemandeFournisseurDelete;
use Modules\CrmAutoCar\Flow\Works\Events\EventClientDossierDemandeFournisseurSend;
use Modules\CrmAutoCar\Flow\Works\Events\EventClientDossierDemandeFournisseurValidate;
use Modules\CrmAutoCar\Flow\Works\Events\EventClientDossierPaiementFournisseurSend;
use Modules\CrmAutoCar\Flow\Works\Events\EventCreateProformatClient;
use Modules\CrmAutoCar\Flow\Works\Events\EventDevisSendClient;


class CoreCRMServiceProvider extends ServiceProvider
{
    /**
     * @var string $moduleName
     */
    protected string $moduleName = 'CoreCRM';

    /**
     * @var string $moduleNameLower
     */
    protected string $moduleNameLower = 'corecrm';


    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->register(RouteServiceProvider::class);
        $this->app->register(AuthServiceProvider::class);

        new NotificationsDispatch();


        $this->app->bind(PipelineRepositoryContract::class, PipelineRepository::class);
        $this->app->bind(ClientRepositoryContract::class, ClientRepository::class);
        $this->app->bind(DossierRepositoryContract::class, DossierRepository::class);
        $this->app->bind(StatusRepositoryContract::class, StatusRepository::class);
        $this->app->bind(SourceRepositoryContract::class, SourceRepository::class);
        $this->app->bind(CommercialRepositoryContract::class, CommercialRepository::class);
        $this->app->bind(DevisRepositoryContract::class, DevisRepository::class);
        $this->app->bind(FournisseurRepositoryContract::class, FournisseurRepository::class);

        $this->app->bind(UserEntity::class, User::class);
        $this->app->bind(DevisEntities::class, Devi::class);
        $this->app->bind(ClientEntity::class, Client::class);

        $this->app->bind(FlowRepositoryContract::class,FlowRepository::class);
        $this->app->bind(EventRepositoryContract::class,EventRepository::class);
        $this->app->bind(FlowContract::class, FlowCRM::class);

        $this->app->bind(WorkflowRepositoryContract::class, WorkflowRepository::class);
        $this->app->singleton(WorkflowKernel::class);


        app(CompositeurThemeContract::class)
            ->setViews(DevisEditViewContract::class,[
                'devis-view' => new TypeView(TypeView::TYPE_BLADE_COMPONENT, 'corecrm::devis-view')
            ]);

    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Blade::directive('prix', function ($money, int $decimals = 0) {
            return "<?php echo Modules\CoreCRM\Helpers\Number::prix($money, $decimals);?>";
        });

        Blade::directive('marge', function ($money, int $decimals = 2) {
            return "<?php echo Modules\CoreCRM\Helpers\Number::marge($money, $decimals);?>";
        });

        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViewsClass();
        $this->registerViews();
        $this->loadMigrationsFrom(module_path($this->moduleName, 'Database/Migrations'));

        app(WorkflowKernel::class)->dispatch();


    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig(): void
    {
        $this->publishes([
            module_path($this->moduleName, 'Config/config.php') => config_path($this->moduleNameLower . '.php'),
        ], 'config');
        $this->mergeConfigFrom(
            module_path($this->moduleName, 'Config/config.php'), $this->moduleNameLower
        );
    }


    /**
     * Register class views blade
     *
     * @return void
     */
    public function registerViewsClass(): void
    {
        Blade::componentNamespace('Modules\CoreCRM\View\Components', 'corecrm');
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews(): void
    {
        $viewPath = resource_path('views/modules/' . $this->moduleNameLower);

        $sourcePath = module_path($this->moduleName, 'Resources/views');

        $this->publishes([
            $sourcePath => $viewPath
        ], ['views', $this->moduleNameLower . '-module-views']);

        $this->loadViewsFrom(array_merge($this->getPublishableViewPaths(), [$sourcePath]), $this->moduleNameLower);
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations(): void
    {
        $langPath = resource_path('lang/modules/' . $this->moduleNameLower);

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, $this->moduleNameLower);
        } else {
            $this->loadTranslationsFrom(module_path($this->moduleName, 'Resources/lang'), $this->moduleNameLower);
        }
    }

    private function getPublishableViewPaths(): array
    {
        $paths = [];
        foreach (Config::get('view.paths') as $path) {
            if (is_dir($path . '/modules/' . $this->moduleNameLower)) {
                $paths[] = $path . '/modules/' . $this->moduleNameLower;
            }
        }
        return $paths;
    }

}
