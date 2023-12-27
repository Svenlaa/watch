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

    <x-form-modal :action="route('creator.create')" button-text="Add Creator">
        <x-input type="text" name="name"/>
        <x-input type="file" name="avatar"/>
    </x-form-modal>
</x-app-layout>
