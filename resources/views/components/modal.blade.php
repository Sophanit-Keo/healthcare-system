@props(['name', 'show' => false, 'maxWidth' => '2xl'])

@php
    $maxWidthClass = match ($maxWidth) {
        'sm' => 'sm:max-w-sm',
        'md' => 'sm:max-w-md',
        'lg' => 'sm:max-w-lg',
        'xl' => 'sm:max-w-xl',
        '2xl' => 'sm:max-w-2xl',
        default => 'sm:max-w-2xl',
    };
@endphp

<div
    x-data="{ show: @js($show) }"
    x-show="show"
    x-on:open-modal.window="show = ($event.detail === '{{ $name }}')"
    x-on:close.window="show = false"
    class="fixed inset-0 z-50 px-4 py-6 sm:px-0 overflow-y-auto"
    style="display: none;"
>
    <div class="fixed inset-0 transform transition-all" x-on:click="show = false">
        <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
    </div>

    <div class="mb-6 bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:w-full {{ $maxWidthClass }} sm:mx-auto">
        {{ $slot }}
    </div>
</div>

