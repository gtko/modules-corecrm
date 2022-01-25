<table class="table mt-4">
    <thead>
    <tr>
        <th class="border-b-2 dark:border-dark-5 whitespace-nowrap">Nom du fichier</th>
        <th class="border-b-2 dark:border-dark-5 whitespace-nowrap">Uploader le</th>
        <th class="border-b-2 dark:border-dark-5 whitespace-nowrap">Par</th>
        <th class="border-b-2 dark:border-dark-5 whitespace-nowrap">Action</th>
    </tr>
    </thead>
    <tbody>
    @forelse($documents as $document)
        <tr>
            <td class="border-b dark:border-dark-5">{{$document->name}}</td>
            <td class="border-b dark:border-dark-5">{{$document->created_at->format('d-m-Y h:i')}}</td>
            <td class="border-b dark:border-dark-5">{{$document->user->format_name}}</td>
            <td class="border-b dark:border-dark-5 flex">
            <span class="cursor-pointer" wire:click="download({{$document->id}})" title="Télécharger le fichier">
                @icon('download')
            </span>
                <x-basecore::ActionConfirm>
            <span class="cursor-pointer" wire:click="delete({{$document->id}})" title="Supprimer le fichier">
                @icon('delete')
            </span>
                </x-basecore::ActionConfirm>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="4">
                <div class="text-center p-8">
                    @icon('empty', null, 'mx-auto h-12 w-12 text-gray-400')
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Aucun document</h3>
                    <p class="mt-1 text-sm text-gray-500">
                        Aucun document sur le dossier
                    </p>
                </div>
            </td>
        </tr>
    @endforelse

    </tbody>
</table>
