<x-corecrm::timeline-item>
    <x-slot name="image">
        <img alt="" src="{{$flow->datas->getUser()->avatar_url}}"/>
    </x-slot>
    <div class="flex items-center">
        <div class="font-medium">
            Appel créé par
            <x-corecrm::timeline.timeline-item-link :url="route('users.show', $flow->datas->getUser())">
                {{$flow->datas->getUser()->format_name}}
            </x-corecrm::timeline.timeline-item-link>
            <div class="font-normal mt-4">
                <div class="mb-2">
                    @if($flow->datas->getAppel()->important)
                        <strong class="text-red-500">Important: </strong>
                    @endif
                    Appel pour le {!! $flow->datas->getAppel()->date->format('d-m-Y H:i') !!}
                </div>
                <div class="mb-2">
                A faire par:
                <strong>
                    {!! $flow->datas->getAppel()->caller->format_name !!}
                </strong>
                </div>
                <livewire:appelcrm::appel-status-joint :appel="$flow->datas->getAppel()"/>
                <div class="my-4">
                    <strong>{!! $flow->datas->getAppel()->note !!}</strong>
                </div>
                <livewire:appelcrm::appelcrm::appel-toggle-joint :appel-id="$flow->datas->getAppel()->id"/>
            </div>
        </div>
        <div class="text-xs text-gray-500 ml-auto">{{$flow->created_at->format('H:i')}}</div>
    </div>
</x-corecrm::timeline-item>
