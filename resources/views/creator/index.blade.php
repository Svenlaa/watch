<x-app-layout x-data="{ modalOpen: {{old('_token') ? 'true' : 'false'}} }"
              class="max-w-7xl mx-auto px-4 relative">

    <div class="grid justify-items-center grid-cols-[repeat(auto-fill,minmax(10rem,_1fr))] py-4 ">
        @foreach($creators as $creator)
            <a href="{{route('creator.show', $creator->id)}}"
               class="flex flex-col w-40 p-2 m-4 hover:bg-primary-50 rounded-lg">
                <x-creator-avatar :path="$creator->avatar_path" :alt="'Avatar for'.$creator->name"
                                  class="rounded-md w-40"/>
                <h3 class="text-center text-lg mt-2">{{$creator->name}}</h3>
            </a>
        @endforeach
    </div>

    <button @click="modalOpen = !modalOpen; $nextTick(() => $(`input[name='name']`).focus())"
            class="fixed bottom-8 right-12 bg-primary-600 hover:bg-primary-700 rounded-full text-white font-bold text-3xl p-2 leading-4"
            title="Create New Creator" type="button">
        <iconify-icon icon="streamline:add-1-solid"/>
    </button>

    <div x-show="modalOpen" style="display: none" class="fixed z-10 inset-0 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>

            <div @click.away="modalOpen = false" class="relative mt-6 mx-auto w-auto" role="dialog" aria-modal="true"
                 aria-labelledby="modal-headline">
                <form method="POST" action="{{route('creator.create')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="shadow overflow-hidden rounded-lg">
                        <div class="bg-gray-50 pt-2 pb-1 px-4">
                            <h2 id="modal-headline" class="text-lg">Add Creator</h2>
                        </div>
                        <div class="bg-white px-4 py-4 sm:p-6 sm:pb-4">
                            <x-input type="text" name="name"/>
                            <x-input type="file" name="avatar"/>
                        </div>
                        <div class="bg-gray-50 py-3 px-4 flex flex-row-reverse gap-4">
                            <button type="submit"
                                    class="bg-primary-600 text-white rounded-sm px-2 py-1 hover:bg-primary-700">
                                Create Creator
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
