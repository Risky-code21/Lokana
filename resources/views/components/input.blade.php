{{-- Props untuk membuat elemen bisa dicustom sesuai keperluan --}}
@props([
    'name' => 'input',
    'id' => null,
    'placeholder' => null,
    'type' => 'text',
    'label' => null,
    'required' => false,
    'disabled' => false,
])

{{-- Container untuk input component --}}
<div class="space-y-2">
    {{-- Label input --}}
    @if ($label)
        <label class="block" for="{{ $id }}">{{ $label }}</label>
    @endif

    {{-- Input field --}}
    <div class="relative flex items-center">
        <input {{ $required ? 'required' : '' }} {{ $disabled ? 'disabled' : '' }} class="input-form-primary"
            type="{{ $type }}" name="{{ $name }}" id="{{ $id }}"
            placeholder="{{ $placeholder }}">

        {{-- Condition untuk menampilkan icon eye-off pada input type password --}}
        @if ($type === 'password')
            {{-- Password visibility toggle button --}}
            <button data-button-toggle-password data-target="{{ $id }}" type="button"
                class="absolute right-4 text-primary-main cursor-pointer">
                {{-- Icon eye untuk password visibility toggle --}}
                <span data-eye-show>
                    <x-heroicon-s-eye class="size-5 text-heading" />
                </span>

                {{-- Icon eye-off untuk password visibility toggle --}}
                <span data-eye-hide class="hidden">
                    <x-heroicon-s-eye-slash class="size-5 text-heading" />
                </span>
            </button>
        @endif

    </div>
    {{-- Condition untuk menampilkan error message --}}
    @error($name)
        <div class="error-status-primary">
            <x-heroicon-s-exclamation-circle class="size-5" />
            <p class="text-inherit m-0"> {{ $message }} </p>
        </div>
    @enderror
</div>
