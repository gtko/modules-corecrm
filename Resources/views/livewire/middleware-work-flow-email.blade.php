<div class="p-4" style="z-index: 900000;">
    <x-corecrm::mentionify.assets/>
    <x-corecrm::mentionify.wrapper :variableData="$variableData" >
        <x-corecrm::workflows.notification-form-email
            :instance="$actionInstance"
            model="actionData"
        >
           <span wire:click="send" class="cursor-pointer inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
               Envoyer l'email
           </span>
        </x-corecrm::workflows.notification-form-email>
    </x-corecrm::mentionify.wrapper>
</div>
