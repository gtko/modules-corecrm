<div>
    @if($dossiers->count() > 0)
        <div class="flex flex-col w-full justify-start items-start p-5 border-t border-gray-200 dark:border-dark-5">
            <div class="flex justify-start items-center">
                @icon('noIcon', null, 'text-red-500 mr-2') Fiche Similaire
            </div>
            <div class="grid grid-cols-1 w-full mt-3 divide-solid divide-y divide-gray-300">
                @foreach($dossiers as $dossier)
                    <a href='{{route('dossiers.show', [$dossier->client->id, $dossier->id])}}' target="_blank" class='py-2 block w-full flex justify-between items-center' >
                        <div class="flex">
                            <x-corecrm::status :label="$dossier->status_label" :color="$dossier->status_color" />
                            <span class="ml-2">#{{$dossier->ref}}</span>
                        </div>
                        <span class="btn btn-primary py-0 px-2 whitespace-nowrap">
                            Voir la fiche
                        </span>
                    </a>
                @endforeach
            </div>
        </div>
    @endif
</div>
