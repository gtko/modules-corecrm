<div class= "relative flex items-center mb-3">
    <div class="report-timeline__image">
        <div class="w-10 h-10 bg-white dark:bg-theme-25 flex flex-none image-fit rounded-full overflow-hidden justify-center items-center">
           @if($image)
               {{$image}}
           @else
                @icon('folder')
            @endif
        </div>
    </div>
    <div {{$attributes->merge(['class' => "box px-5 py-3 ml-4 flex-1"])}}>
        {{ $slot ?? '' }}
    </div>
</div>
