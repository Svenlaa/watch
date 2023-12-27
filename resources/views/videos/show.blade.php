<x-app-layout class="max-w-7xl mx-auto px-4 relative" x-data="{ modalOpen: {{old('_token') ? 'true' : 'false'}} }">
    <video class="inset-0 w-full h-full object-cover"
           src="{{Storage::temporaryUrl($version->source_path, now()->addHour())}}" controls></video>

    <div class="flex flex-row w-full h-16 mt-4 bg-gray-200 rounded-md items-center justify-between">
        <div class="flex flex-row gap-2 items-center">
            <div class="flex flex-row items-center gap-2 ">
                <x-creator-avatar :path="$video->creator->avatar_path" class="h-16 rounded-l-md"/>
                <a class="hover:font-bold"
                   href="{{route('creator.show', ['creator' => $video->creator])}}">{{$video->creator->name}}</a>
            </div>
            <span>-</span>
            <span>{{$video->title}}</span>
        </div>

        <div class="flex flex-row pr-4 gap-2">
            @foreach($video->videoVersions->where('id', '<>', $version->id) as $v)
                <a class="px-2 py-1 rounded-md hover:bg-gray-100 "
                   href="{{route('video.show', ['video' => $video, 'language' => $v->language === $video->language ? null : $v->language])}}">{{$v->language}}</a>
            @endforeach
        </div>
    </div>

    <button @click="modalOpen = !modalOpen; $nextTick(() => $(`input[name='release_date']`).focus())"
            class="fixed bottom-8 right-12 bg-primary-600 hover:bg-primary-700 rounded-full text-white font-bold text-3xl p-2 leading-4"
            title="Create New Video" type="button">
        <iconify-icon icon="streamline:add-1-solid"/>
    </button>

    <x-form-modal :action="route('video.version.create', $video)" button-text="Add Version">
        <x-input type="date" name="release_date"/>
        <x-input type="text" maxlength="2" name="language"/>
        <x-input type="file" name="thumbnail"/>
        <x-input type="file" name="video"/>
    </x-form-modal>
</x-app-layout>
