<x-corecrm::timeline-item>
    <x-slot name="image">
        @if($flow->datas->getUser())
            <img alt="" src="{{$flow->datas->getUser()->avatar_url}}"/>
        @else
            @icon('lightningBolt', null, '')
        @endif
    </x-slot>
    <div class="flex items-center">
        <div class="font-medium">
            @if($flow->datas->getTitre())
            <div class="font-bold">{{$flow->datas->getTitre()}}</div>
            @endif

            @if($flow->datas->getMessage())
                {!! $flow->datas->getMessage() !!}
            @endif
        </div>
        <div class="text-xs text-gray-500 ml-auto">{{$flow->created_at->format('H:i')}}</div>
    </div>
</x-corecrm::timeline-item>
