@props([
    'title' => 'Delete Item?',
    'description' =>
        'Are you sure you want to delete this item? This action cannot be undone and it will be removed permanently.',
    'buttonText' => 'Yes, Delete',
])

<div x-data="{ openDeleteModal: false, deleteUrl: '' }" @open-delete-modal.window="openDeleteModal = true; deleteUrl = $event.detail.url"
    x-show="openDeleteModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title"
    role="dialog" aria-modal="true">

    <div x-show="openDeleteModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity"></div>

    <div class="flex min-h-screen items-center justify-center p-4 text-center sm:p-0">
        <div x-show="openDeleteModal" @click.outside="openDeleteModal = false"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-md">

            <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                <div class="space-y-4">
                    <div class="w-fit block mx-auto">
                        <img class="h-60 md:h-80 w-auto object-contain" src="{{ asset('images/maskot_faq.webp') }}"
                            alt="Lokana Logo" />
                    </div>

                    <div class="mt-3 text-center sm:mt-0">
                        <h1 class="text-3xl font-bold leading-6 text-gray-900" id="modal-title">{{ $title }}
                        </h1>
                        <div class="mt-2">
                            <p class="text-sm mx-auto sm:max-w-4/5 text-gray-500 leading-relaxed">
                                {{ $description }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6 gap-2">

                {{-- Form Rahasia yang akan menembak ke URL yang diterima --}}
                <form :action="deleteUrl" method="POST" class="inline-flex w-full sm:w-auto">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="inline-flex w-full justify-center rounded-lg bg-red-600 p-4 text-sm font-semibold text-white shadow-sm hover:bg-red-700 sm:w-auto transition-colors">
                        {{ $buttonText }}
                    </button>
                </form>

                <button @click="openDeleteModal = false" type="button"
                    class="mt-3 inline-flex w-full justify-center rounded-lg bg-white p-4 text-sm font-semibold text-gray-700 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto transition-colors">
                    Cancel
                </button>
            </div>
        </div>
    </div>
</div>
