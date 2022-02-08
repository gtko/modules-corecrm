<nav aria-label="Progress">
    <ol role="list"
        class="border border-gray-300 bg-white rounded-md divide-y divide-gray-300 md:flex md:divide-y-0 overflow-x-scroll">
        @php($prev = false)
        @foreach($pipeline->statuses->whereNotIn('type', [Modules\CoreCRM\Enum\StatusTypeEnum::TYPE_WIN, Modules\CoreCRM\Enum\StatusTypeEnum::TYPE_LOST]) as $index => $item)
            <li class="relative md:flex">
                <!-- Completed Step -->
                <span wire:click="change({{$item->id}})" class="cursor-pointer group flex items-center w-full">
                <span class="pr-4 pl-2 py-2 flex items-center text-sm font-medium"
                      x-data="{ tooltip: false }"
                      x-on:mouseover="tooltip = true"
                      x-on:mouseover.outside="tooltip = false"
                      x-on:mouseleave="tooltip = false"
                >
                         @if($status->order >= $item->order)
                            <span class="text-white flex-shrink-0 w-10 h-10
                                   flex items-center justify-center bg-green-500 rounded-full group-hover:bg-green-600"
                            >
{{--                                    @icon('check', 30)--}}
                                {{$loop->index+1}}
                            </span>
                    @else
                        <span
                            @if($prev)
                                class="flex-shrink-0 w-10 h-10 flex items-center justify-center border-2 border-indigo-600 rounded-full text-black"
                            @else
                                class="flex-shrink-0 w-10 h-10 flex items-center justify-center border-2 border-gray-300 rounded-full text-black"
                            @endif
                        >
                            <span class=" @if($prev) text-indigo-600 @else text-gray-600 @endif">{{$loop->index+1}}</span>
                        </span>
                    @endif
                        @if($prev)
                        <span class="ml-2 text-sm font-medium text-black whitespace-nowrap"
                              title="{{$item->label}}">
                                    {{$item->label}}
                            </span>
                        @php($prev=false)
                        @else
                        <div class="relative " x-cloak x-show.transition.origin.top="tooltip">
                            <div style="z-index: 10000"
                                 class="absolute top-0 z-50 p-2 -mt-1 text-sm leading-tight text-white transform -translate-x-1/2 -translate-y-full bg-blue-600 rounded-lg shadow-lg whitespace-nowrap">
                                  {{$item->label}}
                            </div>
                        </div>
                    @endif

                    @if($status->order === $item->order)
                        @php($prev=true)
                    @endif
                </span>
            </span>

                <div class="hidden md:block absolute top-0 right-0 h-full w-5" aria-hidden="true">
                    <svg class="h-full w-full text-gray-300" viewBox="0 0 22 80" fill="none" preserveAspectRatio="none">
                        <path d="M0 -2L20 40L0 82" vector-effect="non-scaling-stroke" stroke="currentcolor"
                              stroke-linejoin="round"/>
                    </svg>
                </div>
            </li>
        @endforeach
                <li class="relative md:flex-1">

                    <span class="group flex items-center w-full whitespace-nowrap">
                        <span class="px-6 py-4 flex items-center text-sm font-medium">

                            @if($status->type === Modules\CoreCRM\Enum\StatusTypeEnum::TYPE_WIN)
                                <span class="text-white flex-shrink-0 w-10 h-10
                                       flex items-center justify-center bg-green-500 rounded-full group-hover:bg-green-600">
                                            @icon('checkCircle', 30)
                                    </span>
                            @elseif($status->type === Modules\CoreCRM\Enum\StatusTypeEnum::TYPE_LOST)
                                <span class="text-white flex-shrink-0 w-10 h-10
                                       flex items-center justify-center bg-red-500 rounded-full group-hover:bg-green-600">
                                            @icon('close', 30)
                                    </span>
                            @else
                                <span
                                @if($prev)
                                    class="flex-shrink-0 w-10 h-10 flex items-center justify-center border-2 border-indigo-600 rounded-full text-black"
                                @else
                                    class="flex-shrink-0 w-10 h-10 flex items-center justify-center border-2 border-gray-300 rounded-full text-black"
                                @endif
                                >
                                    <span class=" @if($prev) text-indigo-600 @else text-gray-600 @endif">{{$pipeline->statuses->count() - 1}}</span>
                                </span>
                            @endif

                                <span class="ml-4 text-sm font-medium  @if($prev) text-indigo-600 @else text-gray-600 @endif">
                                @foreach($pipeline->statuses->whereIn('type', [Modules\CoreCRM\Enum\StatusTypeEnum::TYPE_WIN, Modules\CoreCRM\Enum\StatusTypeEnum::TYPE_LOST]) as $item)
                                        <span class="cursor-pointer hover:text-indigo-900
                                        @if($item->id === $status->id && $item->type === Modules\CoreCRM\Enum\StatusTypeEnum::TYPE_WIN) text-green-700 @endif
                                        @if($item->id === $status->id && $item->type === Modules\CoreCRM\Enum\StatusTypeEnum::TYPE_LOST) text-red-700 @endif
                                            "
                                              wire:click="change({{$item->id}})"
                                        >
                                      {{$item->label}}
                                    </span>
                                        @if(!$loop->last) / @endif
                                    @endforeach
                                </span>
                    </span>
        </li>

    </ol>
</nav>
