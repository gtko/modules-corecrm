<x-basecore::partials.card class="mt-4">
    <x-slot name="title">
        Sélectionner une ou plusieurs conditions
    </x-slot>
    <div class="my-5">
        <ul role="list" class="divide-y divide-gray-200 my-2">
            @forelse($this->data['conditions'] as $index => $conditionArray)
                <livewire:corecrm::workflow-form-conditions-item :data="$data" :index="$index" :key="'conditions_'.$index" />
            @empty
                <div>
                    <!-- This example requires Tailwind CSS v2.0+ -->
                    <span type="button" class="relative block w-full border-2 border-gray-300 border-dashed rounded-lg p-12 text-center">
                            @icon('task', null, 'mx-auto h-12 w-12 text-gray-400')
                            <span class="mt-2 block text-sm font-medium text-gray-900 dark:text-white">
                             Aucune condition ne s'applique au workflow.
                          </span>
                        </span>
                </div>
            @endforelse
        </ul>
        <div class="flex justify-start items-center mx-2">
            <x-basecore::loading-replace wire:target="addStatus">
                <x-slot name="loader">
                    <button class="btn btn-default" disabled>
                        @icon('spinner', 20, 'animate-spin mr-2') Ajouter une condition
                    </button>
                </x-slot>
                <button type='button' wire:click="addCondition" class="btn btn-default">@icon('addCircle', 20, 'mr-2') Ajouter une condition</button>
            </x-basecore::loading-replace>
        </div>
    </div>
</x-basecore::partials.card>
