<div x-show="modalOpen" style="display: none" class="fixed z-10 inset-0 overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>

        <div @click.away="modalOpen = false" class="relative mt-6 mx-auto w-auto" role="dialog" aria-modal="true"
             aria-labelledby="modal-headline">
            <form method="POST" action="{{$action}}" enctype="multipart/form-data">
                @csrf
                <div class="shadow overflow-hidden rounded-lg">
                    <div class="bg-gray-50 pt-2 pb-1 px-4">
                        <h2 id="modal-headline" class="text-lg">{{$buttonText}}</h2>
                    </div>
                    <div class="bg-white px-4 py-4 sm:p-6 sm:pb-4">
                        {{$slot}}
                    </div>
                    <div class="bg-gray-50 py-3 px-4 flex flex-row-reverse gap-4">
                        <button type="submit"
                                class="bg-primary-600 text-white rounded-sm px-2 py-1 hover:bg-primary-700">
                            {{$buttonText}}
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
