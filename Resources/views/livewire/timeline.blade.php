    <div class="col-span-12 md:col-span-6 xxl:col-span-12 mt-3 xxl:mt-6">
        <div class="intro-x flex items-center h-10">
            <h2 class="text-lg font-medium truncate mr-5">Activitées</h2>
        </div>
        <div class="report-timeline mt-5 relative" wire:poll.visible="">
            @foreach($flows as $label => $days)
                <div class="intro-x text-gray-500 text-xs text-center my-4">{{$label}}</div>
                @foreach($days as $index => $flow)
                    <x-corecrm::timeline-resolve :key="$index . '__'. $flow->id" :flow="$flow"/>
                @endforeach
            @endforeach
        </div>
    </div>
