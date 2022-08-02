<div class="box mt-5 lg:mt-0">

        <div class="relative flex items-center p-5">
            <div class="w-12 h-12 image-fit">
                <x-basecore::avatar :url="$client->avatar_url"/>
            </div>
            <div class="ml-4 mr-auto">
                <div class="font-medium text-base">{{$client->format_name}}</div>
{{--                <livewire:corecrm::label-status :dossier="$dossier"/>--}}
            </div>
        </div>
        <div class="p-5 border-t border-gray-200 dark:border-dark-5">
            <x-basecore::personne.address-details :personne="$client"/>
        </div>

        <div class="border-t border-gray-200 dark:border-dark-5">
                <div class="flex flex-col">
                    <div class="overflow-x-auto">
                        <div class="inline-block min-w-full align-middle">
                            <div class="overflow-hidden shadow-sm ring-1 ring-black ring-opacity-5">
                                <table class="min-w-full divide-y divide-gray-300">
                                    <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="py-3.5 px-2 text-left text-sm font-semibold text-gray-900">
                                           Infos initiales
                                        </th>
                                        <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6 lg:pl-8">
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200 bg-white">
                                    @foreach(collect($dossier->data)->only(config('corecrm.lead_info')) as $label => $value)
                                        @if(!is_array($value))
                                        <tr>
                                            <td class="px-2">{{$label}}</td>
                                            <td class="px-2">{{$value}}</td>
                                        </tr>
                                        @endif
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
        </div>

        @if(isset($actions))
            <div class="p-5 border-t border-gray-200 dark:border-dark-5 flex">
                {{$actions ?? ''}}
            </div>
        @endif

        <x-basecore::resolve-type-view
            :contrat-view-class="\Modules\CoreCRM\Contracts\Views\Dossiers\SelectCommercial::class"
            :arguments="['client' => $client, 'dossier' => $dossier]"
        />
        <livewire:corecrm::fiche-similaire :dossier="$dossier"/>

        <div>
            <x-basecore::resolve-type-view
                :contrat-view-class="\Modules\CoreCRM\Contracts\Views\Dossiers\SelectTagDossier::class"
                :arguments="['client' => $client, 'dossier' => $dossier]"
            />
        </div>



    </div>
