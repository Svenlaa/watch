<x-app-layout class="max-w-7xl flex-col mx-auto px-4 relative items-center sm:items-start flex sm:flex-row gap-4"
              x-data="{ modalOpen: {{old('_token') ? 'true' : 'false'}} }">
    <div
        class="flex-none w-full sm:sticky top-0 h-min bg-white sm:w-64 flex flex-col items-center rounded-b-md drop-shadow-md">
        <div class="pt-6 px-8 sticky w-64 rounded-b-md drop-shadow-md">
            <x-creator-avatar :path="$creator->avatar_path" :alt="'Avatar for'.$creator->name" class="rounded-xl"/>
            <h2 class="text-center pt-4 text-2xl font-medium">{{$creator->name}}</h2>
            <div
                class="w-100 flex flex-row gap-2 py-2 justify-center leading-[1ch] text-center text-lg font-extrabold text-[#fffd]">
                @foreach($creator->creatorLinks as $link)
                    <a href="{{$link->target}}" title="{{$link->name}}" target="_blank"
                       style="background-color: {{$link->background_color_hex}}"
                       class="rounded-sm p-[0.25ch] w-[1.5ch] h-[1.5ch]">{{$link->letter}}</a>
                @endforeach
                <button @click="modalOpen = !modalOpen; $nextTick(() => $(`input[name='name']`).focus())"
                        class="bg-[#0003] text-black rounded-sm p-[0.25ch] w-[1.8ch] h-[1.5ch]"
                        title="Add Creator Link">
                    +
                </button>
            </div>
        </div>
    </div>

    <div class="w-full grid justify-items-center grid-cols-[repeat(auto-fill,minmax(18rem,_1fr))]">
        @foreach($creator->videos as $video)
            @php($version = $video->getVideoVersion(request()->get('preferred-language')))
            <a href="{{route('video.show', $video->id)}}"
               class="flex flex-col w-72 p-2 m-4 hover:bg-primary-50 rounded-lg">
                <img style="background-image: url('{{config('app.url')}}/images/thumbnail.webp')"
                     class="rounded-md bg-cover w-full aspect-video" alt="Thumbnail for {{$video->title}}"
                     src="{{ $version?->thumbnail_path ? Storage::temporaryUrl($version->thumbnail_path, now()->addHour(1)) : ''}}"/>
                <h3 class="text-center text-lg mt-2">{{$video->title}}</h3>
            </a>
        @endforeach
    </div>

    <x-form-modal :action="route('creator.links.store', $creator)" button-text="Add Creator Link">
        <x-input type="text" name="name"/>
        <x-input type="text" name="target"/>
        <x-input type="text" maxlength="1" name="letter"/>
        <x-input type="color" name="background_color_hex" label="color"/>
    </x-form-modal>
</x-app-layout>
