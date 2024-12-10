<navbar class="w-full bg-primary-500 px-2 block py-1 z-20 relative">
    <div class="container flex items-center justify-between">
        <a href="/" wire:navigate class="block w-24">
            <img src="{{ asset('img/logo.webp') }}" alt="{{ __('Logo Daka') }}">
        </a>
        @if (ticket())
            <livewire:ticket.close-ticket />
        @endif
    </div>
</navbar>
