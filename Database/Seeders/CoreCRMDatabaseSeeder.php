<?php

namespace Modules\CoreCRM\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Modules\BaseCore\Database\Factories\UserFactory;
use Modules\BaseCore\Models\Email;
use Modules\BaseCore\Models\Personne;
use Modules\BaseCore\Models\Phone;
use Modules\CoreCRM\Contracts\Repositories\PipelineRepositoryContract;
use Modules\CoreCRM\Models\Source;
use Modules\CoreCRM\Repositories\PipelineRepository;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class CoreCRMDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        Permission::create(['name' => 'list sources']);
        Permission::create(['name' => 'views sources']);
        Permission::create(['name' => 'create sources']);
        Permission::create(['name' => 'update sources']);
        Permission::create(['name' => 'delete sources']);

        Permission::create(['name' => 'list brands']);
        Permission::create(['name' => 'views brands']);
        Permission::create(['name' => 'create brands']);
        Permission::create(['name' => 'update brands']);
        Permission::create(['name' => 'delete brands']);

        Permission::create(['name' => 'list statuses']);
        Permission::create(['name' => 'views statuses']);
        Permission::create(['name' => 'create statuses']);
        Permission::create(['name' => 'update statuses']);
        Permission::create(['name' => 'delete statuses']);

        Permission::create(['name' => 'list pipelines']);
        Permission::create(['name' => 'views pipelines']);
        Permission::create(['name' => 'create pipelines']);
        Permission::create(['name' => 'update pipelines']);
        Permission::create(['name' => 'delete pipelines']);

        Permission::create(['name' => 'list workflows']);
        Permission::create(['name' => 'views workflows']);
        Permission::create(['name' => 'create workflows']);
        Permission::create(['name' => 'update workflows']);
        Permission::create(['name' => 'delete workflows']);

        Permission::create(['name' => 'list clients']);
        Permission::create(['name' => 'views clients']);
        Permission::create(['name' => 'viewsAll clients']);
        Permission::create(['name' => 'create clients']);
        Permission::create(['name' => 'update clients']);
        Permission::create(['name' => 'delete clients']);

        Permission::create(['name' => 'list dossiers']);
        Permission::create(['name' => 'views dossiers']);
        Permission::create(['name' => 'viewsAll dossiers']);
        Permission::create(['name' => 'create dossiers']);
        Permission::create(['name' => 'update dossiers']);
        Permission::create(['name' => 'delete dossiers']);

        Permission::create(['name' => 'list devis']);
        Permission::create(['name' => 'views devis']);
        Permission::create(['name' => 'create devis']);
        Permission::create(['name' => 'update devis']);
        Permission::create(['name' => 'delete devis']);

        Permission::create(['name' => 'list notes']);
        Permission::create(['name' => 'views notes']);
        Permission::create(['name' => 'create notes']);
        Permission::create(['name' => 'update notes']);
        Permission::create(['name' => 'delete notes']);

        Permission::create(['name' => 'send emails to clients']);

        Permission::create(['name' => 'list documents']);
        Permission::create(['name' => 'views documents']);
        Permission::create(['name' => 'create documents']);
        Permission::create(['name' => 'update documents']);
        Permission::create(['name' => 'delete documents']);

        $arrayTypeUser = ['commercials', 'fournisseurs'];
        foreach($arrayTypeUser as $type) {
            Permission::create(['name' => 'list ' . $type]);
            Permission::create(['name' => 'views ' . $type]);
            Permission::create(['name' => 'create ' . $type]);
            Permission::create(['name' => 'update ' . $type]);
            Permission::create(['name' => 'delete ' . $type]);
        }

        $allPermissions = Permission::all();
        $adminRole = Role::create(['name' => 'manager']);
        $adminRole->givePermissionTo($allPermissions);

        $adminRole = Role::create(['name' => 'fournisseur']);
        $adminRole->givePermissionTo([]);

        $adminRole = Role::create(['name' => 'comptable']);
        $adminRole->givePermissionTo($allPermissions);

        $commercialPermission = Permission::Where('name', 'LIKE', '%devis%')
            ->orWhere('name', 'LIKE', '%dossiers%')
            ->orWhere('name', 'LIKE', '%clients%');
        $commercialRole = Role::create(['name' => 'commercial']);
        $commercialRole->givePermissionTo($commercialPermission);

        $user = UserFactory::new()->create([
            'personne_id' => Personne::factory()
                ->hasAttached(Phone::factory()->create())
                ->hasAttached(Email::factory()->create(['email' => 'commercial@commercial.com'])),
            'password' => \Hash::make('123456'),
        ]);
        $user->assignRole([$commercialRole]);

        Source::create(['label' => 'CRM']);
        Source::create(['label' => 'FORM']);

        $pipelineRep = app(PipelineRepositoryContract::class);
        $pipeline = $pipelineRep->create('default');
        $pipelineRep->isDefault($pipeline);

    }
}
