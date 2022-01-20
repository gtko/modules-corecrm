<nav aria-label="Progress">
    <ol role="list"
        class="border border-gray-300 bg-white rounded-md divide-y divide-gray-300 md:flex md:divide-y-0 overflow-x-scroll">
        @foreach($pipeline->statuses->whereNotIn('type', [Modules\CoreCRM\Enum\StatusTypeEnum::TYPE_WIN, Modules\CoreCRM\Enum\StatusTypeEnum::TYPE_LOST]) as $item)
            <li class="relative md:flex-1 md:flex">
                <!-- Completed Step -->
                <span wire:click="change({{$item->id}})" class="cursor-pointer group flex items-center w-full">
                <span class="px-6 py-4 flex items-center text-sm font-medium">
                         @if($status->order >= $item->order)
                        <span class="text-white flex-shrink-0 w-10 h-10
                           flex items-center justify-center bg-green-500 rounded-full group-hover:bg-green-600"
                        title="{{$item->label}}"
                        >
                                @icon('check', 30)
                            </span>
                    @else
                        <span
                            class="flex-shrink-0 w-10 h-10 flex items-center justify-center border-2 border-indigo-600 rounded-full">
                                <span class="text-indigo-600">{{$loop->index+1}}</span>
                              </span>

                    @endif
                    @if($status->order <= $item->order)
                        <span class="ml-4 text-sm font-medium text-black whitespace-nowrap" title="{{$item->label}}">
                          {{$item->label}}
                      </span>
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
                                    class="flex-shrink-0 w-10 h-10 flex items-center justify-center border-2 border-indigo-600 rounded-full">
                                    <span class="text-indigo-600">{{$pipeline->statuses->count() - 1}}</span>
                                </span>
                            @endif


                            <span class="ml-4 text-sm font-medium text-black">
                            @foreach($pipeline->statuses->whereIn('type', [Modules\CoreCRM\Enum\StatusTypeEnum::TYPE_WIN, Modules\CoreCRM\Enum\StatusTypeEnum::TYPE_LOST]) as $item)
                                    <span class="cursor-pointer hover:text-indigo-700
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
