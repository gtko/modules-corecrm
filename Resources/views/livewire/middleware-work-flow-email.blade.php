<div class="p-4 h-full" style="z-index: 900000;">
    @if($preview)

        <div style="max-height:100%;height:500px;">
            <iframe srcdoc="{{ $this->email }}" class="w-full h-full"></iframe>
        </div>
        <div class="flex justify-end w-full items-center pt-4 space-x-2">
            <span wire:click="editer" class="cursor-pointer inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                   Editer l'email
            </span>
            <x-basecore::loading-replace>
                <x-slot name="loader">
                            <span class="cursor-pointer inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                @icon('spinner', 20, 'animate-spin mr-2') Envoyer l'email
                            </span>
                </x-slot>
                <span wire:click="send" class="cursor-pointer inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                       Envoyer l'email
                </span>
            </x-basecore::loading-replace>
        </div>
    @else
        <x-corecrm::mentionify.assets/>
        <x-corecrm::mentionify.wrapper :variableData="$variableData" >
            <x-corecrm::workflows.notification-form-email
                :instance="$actionInstance"
                model="actionData"
            >
                <x-basecore::loading-replace wire:target="preview">
                    <x-slot name="loader">
                        <span class="cursor-pointer inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            @icon('spinner', 20, 'animate-spin mr-2') Valider l'email
                        </span>
                    </x-slot>
                   <span wire:click="preview" class="cursor-pointer inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                       Valider l'email
                   </span>
                </x-basecore::loading-replace>
            </x-corecrm::workflows.notification-form-email>
        </x-corecrm::mentionify.wrapper>
    @endif
</div>
