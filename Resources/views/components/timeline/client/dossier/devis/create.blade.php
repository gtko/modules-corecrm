<x-corecrm::timeline-item>
    <x-slot name="image">
        <img alt="" src="{{$flow->datas->getUser()->avatar_url}}"/>
    </x-slot>
    <div class="flex items-center">
        @if($flow->datas->getDevis())
        <div class="font-medium">
            Création du
            <x-corecrm::timeline.timeline-item-link :url="route('devis.edit', [$flow->datas->getDevis()->dossier->client, $flow->datas->getDevis()->dossier, $flow->datas->getDevis()])">
                devis#{{$flow->datas->getDevis()->ref}}
            </x-corecrm::timeline.timeline-item-link>

             par
            <x-corecrm::timeline.timeline-item-link :url="route('users.show', $flow->datas->getUser())">
                {{$flow->datas->getUser()->format_name}}
            </x-corecrm::timeline.timeline-item-link>
        </div>
        @endif
        <div class="text-xs text-gray-500 ml-auto">{{$flow->created_at->format('H:i')}}</div>
    </div>
</x-corecrm::timeline-item>
