<div>
    <div class="flex items-center justify-between">
        {{ serviceCall()->Location }}
        <x-mini-button circle primary icon="pencil-square" />
        <x-button label="{{ __('Editar dirección') }}" right-icon="pencil-square" interaction="negative" />

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
