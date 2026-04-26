@php
    $value = strtolower((string) ($status ?? ''));
    $label = $value !== '' ? str_replace('_', ' ', $value) : '-';
    $tone = match ($value) {
        'completed', 'granted', 'active', 'approved' => 'green',
        'cancelled', 'canceled', 'revoked', 'rejected', 'failed' => 'red',
        'no_show', 'pending', 'in_progress' => 'amber',
        default => '',
    };
@endphp

<span class="soft-badge {{ $tone }}">{{ $label }}</span>
