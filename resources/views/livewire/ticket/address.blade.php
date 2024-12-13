<div>
    {{ ticket()->serviceCall->Location }}
    <div id="map" wire:ignore></div>

    @script
        <script>
            const map = L.map('map').setView([10.905458949008, -68.291015625], 13);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors | &copy; <a href="https://tiendasdaka.com/">Tiendas DAKA</a>',
            }).addTo(map);

            L.marker([10.905458949008, -68.291015625]).addTo(map)
        </script>
    @endscript
</div>
