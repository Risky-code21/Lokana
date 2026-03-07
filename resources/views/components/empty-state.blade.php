@props([
    'message' => null,
    'containerClass' => null,
])

<div class="w-full flex flex-col gap-4 items-center justify-center  {{ $containerClass }} ">
    <div class="w-fit block">
        <img class="h-80 w-auto object-contain" src="{{ asset('images/maskot_bingung_v2.webp') }}" alt="Lokana Logo" />
    </div>
    <p class="text-xl text-center w-full font-medium text-gray-400">{{ $message }}
    </p>
</div>
