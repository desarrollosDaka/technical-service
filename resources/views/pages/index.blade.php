<x-layouts.main bodyClass="h-screen overflow-hidden">
    <main class="bg-cover bg-right bg-no-repeat w-full h-screen bg-black" style="background-image: url(/img/header.webp)">
        <div class="container pt-16 px-3">
            <div class="bg-white/90 lg:bg-white/50 rounded-xl p-6 lg:w-1/2 text-center md:text-left">
                <h1 class="font-bold text-lg lg:text-2xl mb-4">
                    <span class="md:block">{{ __('Bienvenido al servicio técnico de ') }}</span>
                    <span class="md:block font-black text-secondary-100 md:text-[1.3em]">{{ __('Tiendas Daka') }}</span>
                </h1>
                <p class="mb-5 text-xs md:text-base">{{ __('Consulta el estado de tu servicio técnico, detalles del ticket, comentarios de los técnicos y más.') }}</p>
                <livewire:ticket.check-ticket />
            </div>
        </div>
    </main>
</x-layouts.main>
