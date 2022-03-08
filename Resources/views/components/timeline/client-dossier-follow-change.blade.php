<x-corecrm::timeline-item>
    <x-slot name="image">
        <img alt="" src="{{$flow->datas->getUser()->avatar_url}}"/>
    </x-slot>
    <div class="flex items-center">
        <div class="font-medium">
           Changement des abonnés sur le dossier :
            <div class="flex justify-start items-center space-x-2">
            @foreach($flow->datas->getFollowers() as $follower)
                <div class="bg-gray-200 p-2">{{$follower->format_name}}</div>
            @endforeach
            </div>
        </div>
        <div class="text-xs text-gray-500 ml-auto">{{$flow->created_at->format('H:i')}}</div>
    </div>
</x-corecrm::timeline-item>
