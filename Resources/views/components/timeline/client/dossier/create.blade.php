<x-corecrm::timeline-item>
    <x-slot name="image">
        <img alt="" src="{{$flow->datas->getUser()->avatar_url ?? 'CRM'}}"/>
    </x-slot>
    <div class="flex items-center">
        <div class="font-medium">
            Création du dossier par
            <span>{{$flow->datas->getUser()->format_name ?? 'CRM'}}</span>


        </div>
        <div class="text-xs text-gray-500 ml-auto">{{$flow->created_at->format('H:i')}}</div>
    </div>
</x-corecrm::timeline-item>
