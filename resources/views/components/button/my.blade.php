@props([
    'outline' => false,
    'loading' => false,
])

@php
    $classes = $outline ? 'text-primary-600 hover:text-primary-600 border-primary-500 hover:bg-primary-500/40' : 'text-secondary-100 bg-primary-500 hover:bg-primary-600 border-primary-500';

    if ($loading || str_contains($attributes->get('class'), 'loading')) {
        $attributes = $attributes->merge([
            'disabled' => true,
        ]);
        $classes .= ' opacity-80 cursor-not-allowed animate-pulse';
    } else {
        $classes .= ' transform active:scale-95';
    }
@endphp

<button
    {{ $attributes->merge([
        'class' => "px-4 py-2 font-bold rounded-lg border flex items-center justify-center {$classes}",
    ]) }}>
    <span>{{ $slot }}</span>
</button>
