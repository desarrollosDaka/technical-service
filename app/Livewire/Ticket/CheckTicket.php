<?php

namespace App\Livewire\Ticket;

use App\Models\ServiceCall;
use Livewire\Attributes\Validate;
use Livewire\Component;

class CheckTicket extends Component
{
    /**
     * Data
     *
     * @var array
     */
    #[Validate([
        'data.identification_type' => 'required|in:V,J,E',
        'data.identification_number' => 'required',
        'data.service_call_id' => 'required',
    ])]
    public array $data = [
        'identification_type' => '',
        'identification_number' => '',
        'service_call_id' => '',
    ];

    /**
     * Mostrar listado de errores
     *
     * @var array
     */
    public array $errorsFeedback = [
        'display' => false,
        'title' => '',
        'messages' => [],
    ];

    /**
     * Mensajes de validación
     *
     * @return void
     */
    protected function messages()
    {
        return [
            'data.identification_type.required' => __('Ingrese un tipo de documento valido'),
            'data.identification_number.required' => __('Ingrese un número de documento valido'),
            'data.service_call_id.required' => __('Ingrese un número de servicio valido'),
        ];
    }

    public function send(): void
    {
        $validated = $this->validate();
        try {
            $serviceCall = ServiceCall::where('callID', $this->data['service_call_id'])
                ->where('customer', $this->data['identification_type'] . '-' . $this->data['identification_number'])
                ->first();

            if (!$serviceCall) {
                throw new \Exception(__('No existe la llamada de servicio'));
            }

            dd($serviceCall);
        } catch (\Throwable $th) {
            $this->errorsFeedback = [
                'display' => true,
                'title' => __('El número de servicio no existe o sú usuario no tiene acceso.'),
                'messages' => [
                    __('Asegúrese de escribir bien la cédula y el numero de servicio.'),
                    __('Si tiene algún problema adicional contacte con xx-xxxx-xxxx.'),
                    $th->getMessage(),
                ],
            ];
        }
    }

    /**
     * Render
     *
     * @return void
     */
    public function render()
    {
        return <<<'BLADE'
            <form wire:submit="send">
                <div class="grid md:grid-cols-5 gap-4 mb-4">
                    <div class="flex gap-2 grid-cols-5 col-span-3">
                        <x-select
                            label="{{ __('Documento') }}"
                            :options="[
                                ['label' => 'V - Venezolano', 'value' => 'V'],
                                ['label' => 'J - Jurídico', 'value' => 'J'],
                                ['label' => 'E - Extranjero', 'value' => 'E'],
                            ]"
                            option-label="label"
                            option-value="value"
                            class="col-span-2"
                            wire:model="data.identification_type"
                        />
                        <x-input
                            label="{{ __('Numero de documento') }}"
                            wire:model="data.identification_number"
                            type="number"
                        />
                    </div>
                    <x-input label="{{ __('Número del servicio') }}" wire:model="data.service_call_id"  type="number" class="col-span-2" />
                </div>
                <x-button primary label="{{ __('Consultar') }}" class="w-full !text-secondary-100 font-black uppercase mb-4" type="submit" />

                @if($this->errorsFeedback['display'])
                    <x-alert title="{{ $this->errorsFeedback['title'] }}" negative padding="none">
                        @if(count($this->errorsFeedback['messages']) > 0)
                            <x-slot name="slot">
                                <ul>
                                    @foreach($this->errorsFeedback['messages'] as $message)
                                        <li>{{ $message }}</li>
                                    @endforeach
                                </ul>
                            </x-slot>
                        @endif
                    </x-alert>
                @endif
            </form>
        BLADE;
    }
}
