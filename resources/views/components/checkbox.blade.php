@props([
    'required' => false,
    'name' => 'checkbox',
    'id' => 'checkbox',
    'label' => 'checkbox',
])

<div class="relative inline-flex items-center gap-2">
    <input type="checkbox" {{ $required ? 'required' : '' }} name="{{ $name }}" id="{{ $id }}"
        class="absolute z-20 inset-0 opacity-0 peer">

    <div
        class=" relative size-5 rounded-sm border border-primary-border peer-checked:bg-primary-main peer-checked:border-primary-main peer-checked:ring-2 peer-checked:ring-primary-border flex justify-center items-center peer-checked:[&>div]:opacity-100 peer-checked:[&>div]:scale-100">
        <div
            class="absolute inset-0 flex items-center justify-center opacity-0 scale-50 transition-all duration-200 ease-back-out text-on-primary">
            <x-heroicon-s-check class="size-3.5 " />
        </div>
    </div>
    <label class="mb-0 text-sm">{{ $label }}</label>
</div>
