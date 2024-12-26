<div>
    @if (serviceCall() && !ticket())
        <h2 class="text-lg text-secondary-100 font-semibold">Aun no se encuentra un técnico asignado a este soporte.</h2>
        <p class="font-bold">{{ __('Número del servicio') }}: {{ serviceCall()->callID }} </p>
        <p class="font-bold mb-6">{{ __('Cliente') }}: {{ serviceCall()->custmrName }} </p>
        <livewire:ticket.close-ticket btnText="Cerrar consulta" color="yellow" />
    @else
        <form wire:submit="send">
            <div class="grid md:grid-cols-5 gap-4 mb-4">
                <div class="flex gap-2 grid-cols-5 md:col-span-3">
                    <x-select
                        label="{{ __('Tipo de documento') }}"
                        :options="[['label' => 'V - Venezolano', 'value' => 'V'], ['label' => 'J - Jurídico', 'value' => 'J'], ['label' => 'E - Extranjero', 'value' => 'E'], ['label' => 'C - Comuna', 'value' => 'C'], ['label' => 'G - Gubernamental', 'value' => 'G']]"
                        option-label="label"
                        option-value="value"
                        class="col-span-2"
                        wire:model="data.identification_type" />
                    <x-input
                        label="{{ __('Número de documento') }}"
                        wire:model="data.identification_number"
                        type="number" />
                </div>
                <x-input label="{{ __('Número del servicio') }}" wire:model="data.service_call_id" type="number" class="md:col-span-2" />
            </div>
            <x-button primary label="{{ __('Consultar') }}" class="w-full !text-secondary-100 font-black uppercase mb-4" type="submit" />

            @if ($this->errorsFeedback['display'])
                <x-alert title="{{ $this->errorsFeedback['title'] }}" negative padding="none">
                    @if (count($this->errorsFeedback['messages']) > 0)
                        <x-slot name="slot">
                            <ul>
                                @foreach ($this->errorsFeedback['messages'] as $message)
                                    <li>{{ $message }}</li>
                                @endforeach
                            </ul>
                        </x-slot>
                    @endif
                </x-alert>
            @endif
        </form>
    @endif
</div>
