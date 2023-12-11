<x-app-layout x-data="{ modalOpen: {{old('_token') ? 'true' : 'false'}} }"
              class="max-w-7xl mx-auto px-4 relative">

    <div class="grid justify-items-center grid-cols-[repeat(auto-fill,minmax(10rem,_1fr))] py-4 ">
        @foreach($actors as $actor)
            <a href="{{route('actor.show', $actor->id)}}"
               class="flex flex-col w-40 p-2 m-4 hover:bg-primary-50 rounded-lg">
                <img class="rounded-md bg-[url('{{config('app.url')}}/images/avatar.webp')] bg-cover w-40 aspect-square"
                     src="{{Storage::temporaryUrl($actor->avatar_path, now()->addHour(1))}}">
                <h3 class="text-center text-lg mt-2">{{$actor->name}}</h3>
            </a>
        @endforeach
    </div>

    <button @click="modalOpen = !modalOpen" title="Create New Actor" type="button"
            class="fixed bottom-8 right-12 bg-primary-600 hover:bg-primary-700 rounded-full text-white font-bold text-3xl p-2 leading-4">
        <iconify-icon icon="streamline:add-1-solid"/>
    </button>

    <div x-show="modalOpen" style="display: none" class="fixed z-10 inset-0 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>

            <div @click.away="modalOpen = false" class="relative mt-6 mx-auto w-auto" role="dialog" aria-modal="true"
                 aria-labelledby="modal-headline">
                <form method="POST" action="{{route('actor.create')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="shadow overflow-hidden rounded-lg">
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">

                            <div class="mt-4 first:mt-0">
                                <label for="inputName" class="block text-sm font-medium text-gray-700">Name:</label>
                                <input type="text" id="inputName" name="name" value="{{old('name') ?? ''}}"
                                       class="mt-1 block w-full p-2 border border-gray-300 rounded-md @error('name') border-red-500 @enderror">
                                @error('name')<span class="text-red-600 text-xs">{{ $message }}</span>@enderror
                            </div>

                            <div class="mt-4 first:mt-0">
                                <label for="inputAvatar" class="block text-sm font-medium text-gray-700">Avatar:</label>
                                <input type="file" id="inputAvatar" name="avatar"
                                       class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md @error('avatar') border-red-500 @enderror">
                                @error('avatar')<span class="text-red-600 text-xs">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse sm:gap-4">
                            <button type="submit"
                                    class="bg-primary-600 text-white rounded-sm px-2 py-1 hover:bg-primary-700">
                                Create Actor
                            </button>
                            <button @click="modalOpen = false" type="button" class="btn btn-secondary">Close</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
