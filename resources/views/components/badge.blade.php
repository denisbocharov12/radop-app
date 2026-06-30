@props(['type' => 'gray'])

@php
    $map = [
        'primary' => 'badge-primary',
        'success' => 'badge-success',
        'warning' => 'badge-warning',
        'danger'  => 'badge-danger',
        'info'    => 'badge-info',
        'gray'    => 'badge-gray',
    ];
    $cls = $map[$type] ?? 'badge-gray';
@endphp

<span {{ $attributes->merge(['class' => $cls]) }}>{{ $slot }}</span>
