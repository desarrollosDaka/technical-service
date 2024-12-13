<div x-data="{ modeEdit: false, address:  }">
    <div class="flex items-center justify-between mb-5">
        {{-- Dirección --}}
        <p x-show="!modeEdit" wire:model="address">Esperando dirección...</p>
        <x-textarea
            x-show="modeEdit"
            label="{{ __('Ingresa la dirección') }}"
            placeholder="{{ __('Escribe la dirección') }}"
            wire:model="address" />

        {{-- Botones --}}
        <x-button
            label="{{ __('Editar dirección') }}"
            right-icon="pencil-square"
            secondary
            light
            x-on:click="modeEdit = true"
            x-show="!modeEdit" />
        <x-button
            label="{{ __('Guardar') }}"
            right-icon="check-circle"
            primary
            x-on:click="modeEdit = false"
            class="text-secondary-100 font-semibold"
            x-show="modeEdit" />
    </div>

    <div id="map" wire:ignore></div>
    @dump(serviceCall())
    @script
        <script>
            const latitude = {{ serviceCall()->latitude ?? 0 }};
            const longitude = {{ serviceCall()->longitude ?? 0 }};
            const map = L.map('map').setView([latitude, longitude], 10);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors | &copy; <a href="https://tiendasdaka.com/">Tiendas DAKA</a>',
            }).addTo(map);

            L.marker([latitude, longitude]).addTo(map)
        </script>
    @endscript
</div>
