<div x-data="{ star: $wire.entangle('star') }">
    <x-button outline primary label="{{ __('Danos tus comentarios') }}" x-on:click="$openModal('qualification')" />


    <x-modal name="qualification" title="{{ __('Calificar soporte') }}">
        <x-card title="{{ __('Calificar soporte') }}">
            <p class="text-neutral-600 text-sm md:max-w-[65%] text-center mx-auto mb-6">¡{{ __('Para tiendas DAKA es importante conocer su opinion de nuestro servicio técnico') }}!</p>

            <div class="flex items-center flex-col">
                <div class="flex justify-center items-center gap-4">
                    <x-icon name="star" class="w-10 h-10 text-primary-100 hover:text-secondary-100" />
                    <x-icon name="star" class="w-10 h-10 text-primary-100 hover:text-secondary-100" />
                    <x-icon name="star" class="w-10 h-10 text-primary-100 hover:text-secondary-100" />
                    <x-icon name="star" class="w-10 h-10 text-primary-100 hover:text-secondary-100" />
                    <x-icon name="star" class="w-10 h-10 text-primary-100 hover:text-secondary-100" />
                </div>
                <p class="text-secondary-100 font-semibold">¿{{ __('Como calificas el soporte obtenido') }}?</p>
            </div>

            <x-slot name="footer" class="flex justify-end gap-x-4">
                <x-button flat label="{{ __('Cancelar') }}" x-on:click="close" />
                <x-button primary label="{{ __('Confirmar') }}" wire:click="send" />
            </x-slot>
        </x-card>
    </x-modal>
</div>
