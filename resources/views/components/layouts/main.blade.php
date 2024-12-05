@props([
    'bodyClass' => '',
])

<x-layouts.base :$bodyClass>
    <x-navbar.container />
    {{ $slot }}
</x-layouts.base>
