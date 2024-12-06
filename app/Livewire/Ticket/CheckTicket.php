<?php

namespace App\Livewire\Ticket;

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
        'data.identification' => 'required',
        'data.service_call_id' => 'required',
    ])]
    public array $data = [
        'identification' => '',
        'service_call_id' => '',
    ];

    protected function messages()
    {
        return [
            'data.identification.required' => __('Ingrese una cédula valida'),
            'data.service_call_id.required' => __('Ingrese un número de servicio valido'),
        ];
    }

    public function send(): void
    {
        $validated = $this->validate();
        dd($this->data);
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
                <div class="flex flex-col md:flex-row gap-4 mb-4">
                    <x-maskable label="{{ __('Ingrese su cédula') }}" wire:model="data.identification" type="number" :mask="['#.###.###', '##.###.###']"  />
                    <x-input label="{{ __('Número del servicio') }}" wire:model="data.service_call_id"  type="number" />
                </div>
                <x-button primary label="{{ __('Consultar') }}" class="w-full" type="submit" />
            </form>
        BLADE;
    }
}
