<x-layouts.main>
    <div class="container py-6">
        <header class="hidden">
            <h1 class="font-bold text-2xl text-secondary-100">@lang('Soporte técnico ID:') {{ serviceCall()->callID }}</h1>
            <x-badge color="{{ ticket()->status->getColor() }}" label="{{ ticket()->status->getLabel() }}" />
        </header>
        <livewire:ticket.details-ticket />
    </div>
</x-layouts.main>
