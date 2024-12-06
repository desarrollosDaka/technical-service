<x-layouts.main>
    <div class="container pt-6">
        <header>
            <h1 class="font-bold text-2xl text-secondary-100">@lang('Soporte técnico ID:') {{ serviceCall()->callID }}</h1>
            <x-badge color="{{ ticket()->status->getColor() }}" label="{{ ticket()->status->getLabel() }}" />
        </header>
        <main class="flex gap-4 pt-6 md:pt-12">
            <section class="w-full md:w-60 flex flex-row md:flex-col gap-5">
                <x-button outline primary label="{{ __('Detalles del ticket') }}" class="md:justify-start" />
                <x-button outline primary label="{{ __('Listado de visitas') }}" class="md:justify-start" />
                <x-button outline primary label="{{ __('Comentarios') }}" class="md:justify-start" />
            </section>
            <section class="w-full"></section>
        </main>
    </div>
</x-layouts.main>
