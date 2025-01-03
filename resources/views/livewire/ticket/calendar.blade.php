<div x-show="displayCalendarMode === 'calendar'" x-data="calendar({ visits: {{ $visits->toJson() }}, reprogrammingReasons: {{ json_encode(\App\Enums\Visit\Reason::getOptions()) }} })">
    <div id="calendar-container-visits" wire:ignore>
    </div>
    <x-modal name="simpleModal" blur="sm" width="large">
        <x-card title="{{ __('Detalles de la visita') }}" class="min-w-96">
            <div class="flex justify-between items-center">
                <h3 class="font-semibold" id="modal-title"></h3>
                <p class="text-sm text-neutral-600" id="modal-date"></p>
            </div>
            <p class="mt-4 text-neutral-800" id="modal-observation"></p>
            <div class="mt-4 " id="modal-reprogramming"></div>
            {{--
            <div class="flex items-center gap-3 mt-3 pt-4 border-t">
                <img class="w-20 rounded-lg" src="{{ asset('img/placeholder.com-1280x720.webp') }}" alt="">
                <img class="w-20 rounded-lg" src="{{ asset('img/placeholder.com-1280x720.webp') }}" alt="">
                <img class="w-20 rounded-lg" src="{{ asset('img/placeholder.com-1280x720.webp') }}" alt="">
            </div> --}}

            <div id="reprogramming"></div>

            <x-slot name="footer" class="flex justify-end gap-x-4">
                <x-button flat label="Cancel" x-on:click="close" />
            </x-slot>
        </x-card>
    </x-modal>
</div>
