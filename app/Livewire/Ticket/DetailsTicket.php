<?php

namespace App\Livewire\Ticket;

use Livewire\Component;

class DetailsTicket extends Component
{
    public string $selectedTab = 'details';

    /**
     * Button
     *
     * @var array
     */
    public array $buttons = [
        'details' => 'Detalles del ticket',
        'visits' => 'Listado de visitas',
        'comments' => 'Comentarios',
    ];

    /**
     * Establecer el tab
     *
     * @param string $tab
     * @return void
     */
    public function setTab(string $tab): void
    {
        $this->selectedTab = $tab;
    }

    /**
     * Render
     *
     * @return string
     */
    public function render(): string
    {
        return <<<'BLADE'
            <main class="flex flex-wrap md:flex-nowrap gap-4">
                <section class="w-full md:w-60 min-w-60 flex flex-col gap-2 md:gap-5">
                    @foreach($buttons as $tab => $label)
                        <x-button.my
                            wire:click="setTab('{{ $tab }}')"
                            class="!justify-start"
                            :outline="$selectedTab !== $tab"
                            wire:loading.class="opacity-80 cursor-wait animate-pulse"
                        >
                            {{ $label }}
                        </x-button.my>
                    @endforeach
                </section>
                <section class="w-full">
                    @if($selectedTab === 'details')
                        <table class="w-full">
                            <tbody>
                                <tr>
                                    <th>
                                        <p class="my-2 text-left">{{ __('Cliente') }}</p>
                                    </th>
                                    <td>{{ ticket()->customer_name }}</td>
                                </tr>
                                <tr>
                                    <th class="text-left">
                                        <p class="my-2">{{ __('Estado') }}</p>
                                    </th>
                                    <td>{{ ticket()->status->getLabel() }}</td>
                                </tr>
                                <tr>
                                    <th class="text-left">
                                        <p class="my-2 min-w-44">
                                            {{ __('Fecha de diagnóstico') }}
                                        </p>
                                    </th>
                                    <td>{{ ticket()->diagnosis_date ? ticket()->diagnosis_date->format('d/m/Y') : __('Sin fechar de diagnostico') }}</td>
                                </tr>
                                <tr>
                                    <th class="text-left">{{ __('Diagnóstico') }}</th>
                                    <td>
                                        <p class="my-2 text-sm">
                                            {{ ticket()->diagnosis_detail }}
                                        </p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    @elseif($selectedTab === 'visits')
                        <div>
                            <livewire:ticket.calendar
                                :drag-and-drop-enabled="false"
                                 initialYear="2019"
                                initialMonth="12"
                            />
                        </div>
                    @elseif($selectedTab === 'comments')
                        <livewire:comment />
                    @endif
                </section>
            </main>
        BLADE;
    }
}
