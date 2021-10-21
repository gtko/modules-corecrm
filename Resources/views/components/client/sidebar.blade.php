<div class="intro-y box mt-5 lg:mt-0">
        <div class="relative flex items-center p-5">
            <div class="w-12 h-12 image-fit">
                <x-basecore::avatar :url="$client->avatar_url"/>
            </div>
            <div class="ml-4 mr-auto">
                <div class="font-medium text-base">{{$client->format_name}}</div>
                <div class="text-gray-600">
                    {{$status ?? ''}}
                </div>
            </div>
        </div>
    
        <div>
            <x-basecore::resolve-type-view
                :contrat-view-class="\Modules\CoreCRM\Contracts\Views\Dossiers\SelectTagDossier::class"
                :arguments="['client' => $client, 'dossier' => $dossier]"
            />
        </div>

        <div class="p-5 border-t border-gray-200 dark:border-dark-5">
            <x-basecore::personne.address-details :personne="$client"/>
        </div>
        @if(isset($actions))
        <div class="p-5 border-t border-gray-200 dark:border-dark-5 flex">
            {{$actions ?? ''}}
        </div>
        @endif
    </div>
