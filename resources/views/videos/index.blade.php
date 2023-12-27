<x-app-layout x-data="{ modalOpen: {{old('_token') ? 'true' : 'false'}} }"
              class="max-w-7xl mx-auto px-4 relative">

    <div class="grid justify-items-center grid-cols-[repeat(auto-fill,minmax(18rem,_1fr))] py-4">
        @foreach($videos as $video)
            @php($source = $video->getVideoVersion(request()->get('preferred-language')))
            <a href="{{route('video.show', $video->id)}}"
               class="flex flex-col w-72 p-2 m-4 hover:bg-primary-50 rounded-lg">
                <img style="background-image: url('{{config('app.url')}}/images/thumbnail.webp')"
                     class="rounded-md bg-cover w-full aspect-video" alt="Thumbnail for {{$video->title}}"
                     src="{{ $source?->thumbnail_path ? Storage::temporaryUrl($source->thumbnail_path, now()->addHour(1)) : ''}}"/>
                <h3 class="text-center text-lg mt-2">{{$video->title}}</h3>
            </a>
        @endforeach
    </div>

    <button @click="modalOpen = !modalOpen; $nextTick(() => $(`input[name='title']`).focus())"
            class="fixed bottom-8 right-12 bg-primary-600 hover:bg-primary-700 rounded-full text-white font-bold text-3xl p-2 leading-4"
            title="Add Video" type="button">
        <iconify-icon icon="streamline:add-1-solid"/>
    </button>

    <div x-show="modalOpen" style="display: none" class="fixed z-10 inset-0 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>

            <div @click.away="modalOpen = false" class="relative mt-6 mx-auto w-auto" role="dialog" aria-modal="true"
                 aria-labelledby="modal-headline">
                <form method="POST" action="{{route('video.create')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="shadow overflow-hidden rounded-lg">
                        <div class="bg-gray-50 pt-2 pb-1 px-4">
                            <h2 id="modal-headline" class="text-lg">Add Video</h2>
                        </div>
                        <div class="bg-white px-4 py-4 sm:p-6 sm:pb-4">
                            <x-input type="text" name="title"/>
                            <x-input type="date" name="release_date"/>
                            <x-input type="text" name="language" maxlength="2"/>

                            <div class="mt-4 first:mt-0">
                                <label for="creatorInput"
                                       class="block text-sm font-medium text-gray-700">Creator:</label>
                                <select id="creatorInput" name="creator_id"
                                        class="mt-1 block w-full p-2 border border-gray-300 rounded-md @error('language') border-red-500 @enderror">
                                    @foreach($creators as $creator)
                                        <option
                                            value="{{$creator->id}}" {{old('creator_id') == $creator->id ? 'selected' : ''}} >{{$creator->name}}</option>
                                    @endforeach
                                </select>
                                @error('creator_id')<span class="text-red-600 text-xs">{{ $message }}</span>@enderror
                            </div>

                            <x-input type="file" name="thumbnail"/>
                            <x-input type="file" name="video"/>
                        </div>
                        <div class="bg-gray-50 py-3 px-4 flex flex-row-reverse gap-4">
                            <button type="submit"
                                    class="bg-primary-600 text-white rounded-sm px-2 py-1 hover:bg-primary-700">
                                Add Video
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
