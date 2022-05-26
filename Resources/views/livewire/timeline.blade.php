    <div class="col-span-12 md:col-span-6 xxl:col-span-12 mt-3 xxl:mt-6">
        <div class="intro-x flex items-center h-10">
            <h2 class="text-lg font-medium truncate mr-5">Activitées</h2>
        </div>

        <div>

            <select wire:model="filter">
                <option value="all">Tous</option>
                <option value="note">Notes</option>
                <option value="task">Tâches</option>
                <option value="call">Appel</option>
                <option value="email">Emails</option>
                <option value="event">Activité</option>
            </select>

        </div>

        <div class="report-timeline mt-5 relative" @if($polling) wire:poll.5s.visible="" @endif>
            @foreach($flows as $label => $days)
                <div class="intro-x text-gray-500 text-xs text-center my-4">{{$label}}</div>
                @foreach($days as $index => $flow)
                    @if($flow ?? false)
                        <x-corecrm::timeline-resolve :key="$index . '__'. $flow->id" :flow="$flow"/>
                    @else
                        <span class="text-danger-700">Erreur</span>
                    @endif
                @endforeach
            @endforeach
        </div>
    </div>
