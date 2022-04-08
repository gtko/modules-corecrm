<div class="col-span-12 md:col-span-6 xxl:col-span-12 mt-3 xxl:mt-6 p-4 box">
    <div class="intro-x flex items-center h-10">
        <h2 class="text-lg font-medium truncate mr-5 flex items-center">

            <svg class="h-5 w-5 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M211.8 339.8C200.9 350.7 183.1 350.7 172.2 339.8L108.2 275.8C97.27 264.9 97.27 247.1 108.2 236.2C119.1 225.3 136.9 225.3 147.8 236.2L192 280.4L300.2 172.2C311.1 161.3 328.9 161.3 339.8 172.2C350.7 183.1 350.7 200.9 339.8 211.8L211.8 339.8zM0 96C0 60.65 28.65 32 64 32H384C419.3 32 448 60.65 448 96V416C448 451.3 419.3 480 384 480H64C28.65 480 0 451.3 0 416V96zM48 96V416C48 424.8 55.16 432 64 432H384C392.8 432 400 424.8 400 416V96C400 87.16 392.8 80 384 80H64C55.16 80 48 87.16 48 96z"/></svg>
            <span>A Faire sur ce dossier</span>
        </h2>
    </div>

    <div>
        <div class="intro-y inbox box mt-5">
            <div class="p-5 flex flex-col-reverse sm:flex-row text-slate-500 border-b border-slate-200/60">
                <div class="flex items-center mt-3 sm:mt-0 border-t sm:border-0 border-slate-200/60 pt-5 sm:pt-0 mt-5 sm:mt-0 -mx-5 sm:mx-0 px-5 sm:px-0">
                    <span class="flex items-center justify-center">
                        <svg class='h-4 w-4 mr-1' xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M481.2 33.81c-8.938-3.656-19.31-1.656-26.16 5.219l-50.51 50.51C364.3 53.81 312.1 32 256 32C157 32 68.53 98.31 40.91 193.3C37.19 206 44.5 219.3 57.22 223c12.81 3.781 26.06-3.625 29.75-16.31C108.7 132.1 178.2 80 256 80c43.12 0 83.35 16.42 114.7 43.4l-59.63 59.63c-6.875 6.875-8.906 17.19-5.219 26.16c3.719 8.969 12.47 14.81 22.19 14.81h143.9C485.2 223.1 496 213.3 496 200v-144C496 46.28 490.2 37.53 481.2 33.81zM454.7 288.1c-12.78-3.75-26.06 3.594-29.75 16.31C403.3 379.9 333.8 432 255.1 432c-43.12 0-83.38-16.42-114.7-43.41l59.62-59.62c6.875-6.875 8.891-17.03 5.203-26C202.4 294 193.7 288 183.1 288H40.05c-13.25 0-24.11 10.74-24.11 23.99v144c0 9.719 5.844 18.47 14.81 22.19C33.72 479.4 36.84 480 39.94 480c6.25 0 12.38-2.438 16.97-7.031l50.51-50.52C147.6 458.2 199.9 480 255.1 480c99 0 187.4-66.31 215.1-161.3C474.8 305.1 467.4 292.7 454.7 288.1z"/></svg>
                        refresh
                    </span>
                </div>
                <div class="flex items-center sm:ml-auto">
                    <div class="">{{$tasks->count()}} tâche{{($tasks->count() > 1)?'s':''}}</div>
                </div>
            </div>
            <div class="overflow-x-auto sm:overflow-x-visible">
                @foreach($tasks as $task)
                        <livewire:corecrm::dossier-tasks-item :task="$task" :key="$task->id" />
                @endforeach
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
