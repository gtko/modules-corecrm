<x-corecrm::timeline-item>
    <x-slot name="image">
        <img alt="" src="{{$flow->datas->getUser()->avatar_url}}"/>
    </x-slot>
    <div class="flex items-center">
        <div class="font-medium">
            Création du dossier par
            <x-corecrm::timeline.timeline-item-link :url="route('users.show', $flow->datas->getUser())">
                {{$flow->datas->getUser()->format_name}}
            </x-corecrm::timeline.timeline-item-link>
                <ul>
                    <li>
                        <span class="font-bold">Dépar le : </span>
                        <span class="text-blue-400">{{$flow->flowable->data['date_depart'] ?? 'N/A'}}</span>
                    </li>
                    <li>
                        <span class="font-bold">Dépar de : </span>
                        <span class="text-blue-400">{{$flow->flowable->data['lieu_depart'] ?? 'N/A'}}</span>
                    </li>
                    <li>
                        <span class="font-bold">Arrivée le : </span>
                        <span class="text-blue-400">{{$flow->flowable->data['date_arrivee'] ?? 'N/A'}}</span>
                    </li>
                    <li>
                        <span class="font-bold">Arrivée à : </span>
                        <span class="text-blue-400">{{$flow->flowable->data['lieu_arrivee'] ?? 'N/A'}}</span>
                    </li>
                </ul>
        </div>
        <div class="text-xs text-gray-500 ml-auto">{{$flow->created_at->format('H:i')}}</div>
    </div>
</x-corecrm::timeline-item>
