<x-app-layout class="max-w-7xl mx-auto px-4 relative">

    <video class="inset-0 w-full h-full object-cover"
           src="{{Storage::temporaryUrl($source->source_path, now()->addHour())}}" controls></video>

    <div class="flex flex-row w-full h-16 mt-4 bg-gray-200 rounded-md items-center gap-2">
        <div class="flex flex-row items-center gap-2 ">
            <x-creator-avatar :path="$video->creator->avatar_path" class="h-16 rounded-l-md"/>
            <a class="hover:font-bold"
               href="{{route('creator.show', ['creator' => $video->creator])}}">{{$video->creator->name}}</a>
        </div>
        <span>-</span>
        <span>{{$video->title}}</span>
    </div>
</x-app-layout>
