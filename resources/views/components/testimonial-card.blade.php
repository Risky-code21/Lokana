@props([
    'name' => 'Hendric amba',
    'initials' => 'HA',
    'message' =>
        'an effort to connect Balinese artisans with the wider community through a digital platform, so that local works and products',
])

<div
    {{ $attributes->merge(['class' => 'break-inside-avoid mb-6 w-full bg-white rounded-3xl p-6 md:p-8 border border-surface-medium shadow-sm flex items-start gap-4 md:gap-6']) }}>

    {{-- Avatar Inisial --}}
    <div
        class="size-12 md:size-16 rounded-full bg-primary-main text-white flex items-center justify-center font-paragraph font-semibold text-lg md:text-xl flex-shrink-0">
        {{ $initials }}
    </div>

    {{-- Konten Teks --}}
    <div class="flex-grow">
        <h4 class="font-heading font-medium text-lg md:text-xl text-black mb-2">
            {{ $name }}
        </h4>
        <p class="font-paragraph text-text-body text-sm md:text-base leading-relaxed">
            {{ $message }}
        </p>
    </div>

</div>
