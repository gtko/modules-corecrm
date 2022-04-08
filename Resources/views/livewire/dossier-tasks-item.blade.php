<div class="inbox__item inline-block sm:block text-slate-600 dark:text-slate-500 bg-slate-100 dark:bg-darkmode-400/70 border-b border-slate-200/60 dark:border-darkmode-400">
    <div class="flex px-5 py-3">
        <div class="w-56 flex-none flex items-center mr-5">
            <input class="form-check-input flex-none" type="checkbox" checked="">
            <a href="javascript:;" class="w-5 h-5 flex-none ml-4 flex items-center justify-center text-slate-400">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="star" class="lucide lucide-star w-4 h-4" data-lucide="star"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
            </a>
            <div class="w-6 h-6 flex-none image-fit relative ml-5">
                <img alt="" class="rounded-full" src="{{$task->user->avatar_url}}">
            </div>
            <div class="inbox__item--sender truncate ml-3">{{$task->user->format_name}}</div>
        </div>
        <div class="w-72 sm:w-auto truncate">
            {{ $task->content }}
        </div>
        <div class="inbox__item--time whitespace-nowrap ml-auto pl-10">
            {{$task->start->format('d/m/Y H:i:s')}}
        </div>
    </div>
</div>
