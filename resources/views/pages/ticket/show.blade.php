<x-layouts.main>
    <div class="container pt-6">
        <h1 class="font-bold text-2xl text-secondary-100">@lang('Soporte técnico ID:') {{ serviceCall()->callID }}</h1>
        <x-badge color="{{ ticket()->status->getColor() }}" label="{{ ticket()->status->getLabel() }}" />
        {{ ticket()->id }}
    </div>
</x-layouts.main>
