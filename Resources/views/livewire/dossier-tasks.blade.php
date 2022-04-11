<div class="col-span-12 md:col-span-6 xxl:col-span-12 mt-3 xxl:mt-6 p-4 box">
    <div class="intro-x flex items-center h-10">
        <h2 class="text-lg font-medium truncate mr-5 flex items-center">

            <svg class="h-5 w-5 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M211.8 339.8C200.9 350.7 183.1 350.7 172.2 339.8L108.2 275.8C97.27 264.9 97.27 247.1 108.2 236.2C119.1 225.3 136.9 225.3 147.8 236.2L192 280.4L300.2 172.2C311.1 161.3 328.9 161.3 339.8 172.2C350.7 183.1 350.7 200.9 339.8 211.8L211.8 339.8zM0 96C0 60.65 28.65 32 64 32H384C419.3 32 448 60.65 448 96V416C448 451.3 419.3 480 384 480H64C28.65 480 0 451.3 0 416V96zM48 96V416C48 424.8 55.16 432 64 432H384C392.8 432 400 424.8 400 416V96C400 87.16 392.8 80 384 80H64C55.16 80 48 87.16 48 96z"/></svg>
            <span>A Faire sur ce dossier</span>
        </h2>
    </div>

    <div wire:poll.visible>
        <div class="intro-y inbox">
            <div class="p-5 flex flex-col-reverse sm:flex-row text-slate-500 border-b border-slate-200/60">
                <div class="flex items-center mt-3 sm:mt-0 border-t sm:border-0 border-slate-200/60 pt-5 sm:pt-0 mt-5 sm:mt-0 -mx-5 sm:mx-0 px-5 sm:px-0">
                </div>
                <div class="flex items-center sm:ml-auto">
                    <div class="">{{$tasks->count()}} tâche{{($tasks->count() > 1)?'s':''}}</div>
                </div>
            </div>
            <div class="overflow-x-auto sm:overflow-x-visible">
                @forelse($tasks as $task)
                    <livewire:corecrm::dossier-tasks-item :task="$task" :key="$task->id" />
                @empty
                    <div class="text-center mt-10">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill='currentColor' xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M485.7 26.34c-3.125-3.125-8.188-3.125-11.31 0l-77.19 77.19C360.1 69.17 310.6 48 256 48C141.1 48 48 141.1 48 256c0 54.56 21.17 104.1 55.54 141.2l-77.19 77.19c-3.125 3.125-3.125 8.188 0 11.31C27.91 487.2 29.94 488 32 488s4.094-.7813 5.656-2.344l77.19-77.19C151.9 442.8 201.4 464 256 464c114.9 0 208-93.13 208-208c0-54.56-21.17-104.1-55.54-141.2l77.19-77.19C488.8 34.53 488.8 29.47 485.7 26.34zM64 256c0-105.9 86.13-192 192-192c50.06 0 95.56 19.42 129.8 50.91L114.9 385.8C83.42 351.6 64 306.1 64 256zM448 256c0 105.9-86.13 192-192 192c-50.06 0-95.56-19.42-129.8-50.91l270.9-270.9C428.6 160.4 448 205.9 448 256z"/></svg>
                        <h3 class="mt-2 text-xl font-medium text-gray-900">🎉 Super !</h3>
                        <p class="mt-1 text-sm text-gray-500">
                            il n'y a aucune tâche sur le dossier.
                        </p>
                    </div>
                @endforelse
            </div>
            <div class="p-5 flex flex-col sm:flex-row items-center text-center sm:text-left text-slate-500">
                <div></div>
                <div class="sm:ml-auto mt-2 sm:mt-0">
                    @if($tasks->count() > 0)
                        Dernière tâche ajoutée
                        {{$tasks->last()->created_at->diffForHumans()}}
                    @else
                        Aucune tâche pour le moment
                    @endif
                </div>
            </div>
        </div>

    </div>

</div>
