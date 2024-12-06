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
            <main class="flex flex-wrap md:flex-nowrap gap-4 pt-6 md:pt-12">
                <section class="w-full md:w-60 flex flex-col gap-2 md:gap-5">
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
                    {{ ticket()->id }}
                </section>
            </main>
        BLADE;
    }
}
