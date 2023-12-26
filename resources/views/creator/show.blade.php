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
                        title="Create Creator Link">
                    +
                </button>
            </div>

        </div>
    </div>
    <div class="w-full grid justify-items-center grid-cols-[repeat(auto-fill,minmax(18rem,_1fr))]">
        @foreach($creator->videos as $video)
            @php($version = $video->getVideoVersion())
            <a href="{{route('video.show', $video->id)}}"
               class="flex flex-col w-72 p-2 m-4 hover:bg-primary-50 rounded-lg">
                <img style="background-image: url('{{config('app.url')}}/images/thumbnail.webp')"
                     class="rounded-md bg-cover w-full aspect-video" alt="Thumbnail for {{$video->title}}"
                     src="{{ $version?->thumbnail_path ? Storage::temporaryUrl($version->thumbnail_path, now()->addHour(1)) : ''}}"/>
                <h3 class="text-center text-lg mt-2">{{$video->title}}</h3>
            </a>
        @endforeach
    </div>
    <div x-show="modalOpen" style="display: none" class="fixed z-10 inset-0 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>

            <div @click.away="modalOpen = false" class="relative mt-6 mx-auto w-auto" role="dialog" aria-modal="true"
                 aria-labelledby="modal-headline">
                <form method="POST" action="{{route('creator.links.store', $creator)}}" enctype="multipart/form-data">
                    @csrf
                    <div class="shadow overflow-hidden rounded-lg">
                        <div class="bg-gray-50 pt-2 pb-1 px-4">
                            <h2 id="modal-headline" class="text-lg">Add Creator Link</h2>
                        </div>
                        <div class="bg-white px-4 py-4 sm:p-6 sm:pb-4">
                            <div class="mt-4 first:mt-0">
                                <label for="inputName" class="block text-sm font-medium text-gray-700">Name:</label>
                                <input type="text" name="name" value="{{old('name') ?? ''}}"
                                       class="mt-1 block w-full p-2 border border-gray-300 rounded-md @error('name') border-red-500 @enderror">
                                @error('name')<span class="text-red-600 text-xs">{{ $message }}</span>@enderror
                            </div>

                            <div class="mt-4 first:mt-0">
                                <label for="inputTarget" class="block text-sm font-medium text-gray-700">Target:</label>
                                <input type="text" name="target" value="{{old('target') ?? ''}}"
                                       class="mt-1 block w-full p-2 border border-gray-300 rounded-md @error('target') border-red-500 @enderror">
                                @error('target')<span class="text-red-600 text-xs">{{ $message }}</span>@enderror
                            </div>

                            <div class="mt-4 first:mt-0">
                                <label for="inputLetter" class="block text-sm font-medium text-gray-700">Letter:</label>
                                <input type="text" name="letter" value="{{old('letter') ?? ''}}" maxlength="1"
                                       class="mt-1 block w-full p-2 border border-gray-300 rounded-md @error('letter') border-red-500 @enderror">
                                @error('letter')<span class="text-red-600 text-xs">{{ $message }}</span>@enderror
                            </div>

                            <div class="mt-4 first:mt-0">
                                <label for="inputColor" class="block text-sm font-medium text-gray-700">Color:</label>
                                <input type="color" name="background_color_hex"
                                       value="{{old('background_color_hex') ?? ''}}"
                                       class="mt-1 block w-full p-2 border border-gray-300 rounded-md @error('background_color_hex') border-red-500 @enderror">
                                @error('background_color_hex')<span
                                    class="text-red-600 text-xs">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="bg-gray-50 py-3 px-4 flex flex-row-reverse gap-4">
                            <button type="submit"
                                    class="bg-primary-600 text-white rounded-sm px-2 py-1 hover:bg-primary-700">
                                Create Creator Link
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
