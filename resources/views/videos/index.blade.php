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

    <x-form-modal :action="route('video.create')" button-text="Add Video">
        <x-input type="text" name="title"/>
        <x-input type="date" name="release_date"/>
        <x-input type="text" name="language" maxlength="2"/>

        <div class="mt-4 first:mt-0">
            <label for="creatorInput"
                   class="block text-sm font-medium text-gray-700">Creator:</label>
            <select id="creatorInput" name="creator_id"
                    class="mt-1 block w-full p-2 border {{$errors->get('language') ? 'border-red-500':'border-gray-300'}} rounded-md">
                @foreach($creators as $creator)
                    <option
                        value="{{$creator->id}}" {{old('creator_id') == $creator->id ? 'selected' : ''}} >{{$creator->name}}</option>
                @endforeach
            </select>
            @error('creator_id')<span class="text-red-600 text-xs">{{ $message }}</span>@enderror
        </div>

        <x-input type="file" name="thumbnail"/>
        <x-input type="file" name="video"/>
    </x-form-modal>
</x-app-layout>
