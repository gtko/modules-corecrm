<x-basecore::form
    method="PUT"
    action="{{ route('clients.update', $client->id) }}"
>
    <x-basecore::personne.form :editing="isset($client)" :personne="$client"/>
    <div class="mt-5 px-2 flex justify-between">
       <div>
           {{$slot}}
       </div>
        <x-basecore::button type="submit">
            <i class="mr-1 icon ion-md-save"></i>
            @lang('basecore::crud.common.update')
        </x-basecore::button>
    </div>
</x-basecore::form>
