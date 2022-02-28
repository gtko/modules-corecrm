<x-basecore::app-layout>
    <x-slot name="breadcrumb">
        <x-basecore::breadcrumb-item>Fournisseurs</x-basecore::breadcrumb-item>
    </x-slot>

    <div class="overflow-auto lg:overflow-visible mt-8 sm:mt-0">
        <table class="table table-report sm:mt-2">
            <thead>
            <tr>
                <th class="whitespace-nowrap"></th>
                <th class="text-center whitespace-nowrap">Nom</th>
                <th class="text-center whitespace-nowrap">tags</th>
                <th class="text-center whitespace-nowrap"></th>
            </tr>
            </thead>
            <tbody>
            @foreach($fournisseurs as $fournisseur)
                <tr>
                    <td class="text-center">
                        #{{$fournisseur->id}}
                    </td>
                    <td class="text-center">
                        {{$fournisseur->format_name}}
                    </td>
                    <td class="text-center">
                        {{$fournisseur->tagfournisseurs->pluck('name')->implode(', ')}}
                    </td>
                    <td>
                        <a href="{{route('fournisseurs.edit', $fournisseur)}}">
                            @icon('edit', null, 'mr-2')
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

</x-basecore::app-layout>
