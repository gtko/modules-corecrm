<x-corecrm::timeline-item>
    <x-slot name="image">
        <img alt="" src="{{$flow->datas->getUser()->avatar_url}}"/>
    </x-slot>
    <div class="flex items-center">
        <div class="font-medium">
            Mise à jour du
            <x-corecrm::timeline.timeline-item-link
                :url="route('devis.edit', [$flow->datas->getDevis()->dossier->client, $flow->datas->getDevis()->dossier, $flow->datas->getDevis()])">
                devis#{{$flow->datas->getDevis()->ref}}
            </x-corecrm::timeline.timeline-item-link>
            par
            <x-corecrm::timeline.timeline-item-link :url="route('users.show', $flow->datas->getUser())">
                {{$flow->datas->getUser()->format_name}}
            </x-corecrm::timeline.timeline-item-link>
            @if(isset($flow->datas->getData()['commentaire']) && $flow->datas->getData()['commentaire'] != '' )
                <div>
                    Avec le commentaire : {{ $flow->datas->getData()['commentaire'] }}
                </div>
            @endif
        </div>
        <div class="text-xs text-gray-500 ml-auto">{{$flow->created_at->format('H:i')}}</div>
    </div>
</x-corecrm::timeline-item>
