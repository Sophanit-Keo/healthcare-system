@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'p-3 rounded bg-green-50 text-green-800 text-sm']) }}>
        {{ $status }}
    </div>
@endif

