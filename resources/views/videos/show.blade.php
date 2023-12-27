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

    <div x-show="modalOpen" style="display: none" class="fixed z-10 inset-0 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>

            <div @click.away="modalOpen = false" class="relative mt-6 mx-auto w-auto" role="dialog" aria-modal="true"
                 aria-labelledby="modal-headline">
                <form method="POST" action="{{route('video.version.create', compact('video'))}}"
                      enctype="multipart/form-data">
                    @csrf
                    <div class="shadow overflow-hidden rounded-lg">
                        <div class="bg-gray-50 pt-2 pb-1 px-4">
                            <h2 id="modal-headline" class="text-lg">Add Version</h2>
                        </div>
                        <div class="bg-white px-4 py-4 sm:p-6 sm:pb-4">
                            <x-input type="date" name="release_date"/>
                            <x-input type="text" maxlength="2" name="language"/>
                            <x-input type="file" name="thumbnail"/>
                            <x-input type="file" name="video"/>
                        </div>
                        <div class="bg-gray-50 py-3 px-4 flex flex-row-reverse gap-4">
                            <button type="submit"
                                    class="bg-primary-600 text-white rounded-sm px-2 py-1 hover:bg-primary-700">
                                Add Version
                            </button>
                            <button type="button" @click="modalOpen = false"
                                    class="rounded-sm px-2 py-1 hover:bg-gray-100">
                                Close
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

</x-app-layout>
