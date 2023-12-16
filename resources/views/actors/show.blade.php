<x-app-layout class="max-w-7xl flex-col mx-auto px-4 relative items-center sm:items-start flex sm:flex-row gap-4">
    <div
        class="flex-none w-full sm:sticky top-0 h-min bg-white sm:w-64 flex flex-col items-center rounded-b-md drop-shadow-md">
        <div class="pt-6 px-8 sticky w-64 rounded-b-md drop-shadow-md">
            <img src="{{Storage::temporaryUrl($actor->avatar_path, now()->addHour(1))}}"
                 class="rounded-xl bg-[url('{{config('app.url')}}/images/avatar.webp')]"/>
            <h2 class="text-center py-4 text-2xl font-medium">{{$actor->name}}</h2>
        </div>
    </div>
    <div class="w-full"></div>
</x-app-layout>
