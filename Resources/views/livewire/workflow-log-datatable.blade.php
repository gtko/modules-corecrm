<div class="mt-5 relative">

    <div wire:loading class="border border-b-0 border-r-0 absolute top-0 w-full left-0 h-14 flex items-center justify-center z-40 bg-gray-50 text-gray-800 rounded p-2">
        <div class="flex justify-start items-center w-full h-full">
            @icon('spinner', 20, 'text-blue-500 animate-spin')
            <span class="ml-2 text-base">Chargement de la liste</span>
        </div>
    </div>

    {{ $this->table }}
</div>
