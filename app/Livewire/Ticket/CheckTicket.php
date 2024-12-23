<?php

namespace App\Livewire\Ticket;

use App\Models\ServiceCall;
use Illuminate\Support\Facades\Cache;
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

            Cache::put('service_call_for:' . request()->ip(), $serviceCall, 60 * 60 * 24);
            redirect()->route('ticket.show');
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
        return view('livewire.ticket.check');
    }
}
