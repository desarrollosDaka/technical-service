<div x-data="{ modeEdit: false, address: '' }">
    <div class="flex items-center justify-between mb-5">
        {{-- Dirección --}}
        {{-- <p x-show="!modeEdit">{{ serviceCall()->Location }}</p> --}}
    </div>
    @if (serviceCall()->latitude && serviceCall()->longitude)
        <div id="map" wire:ignore class="z-10"></div>
    @endif
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
