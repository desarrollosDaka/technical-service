<main class="flex flex-wrap md:flex-nowrap gap-4" x-data="detailsTicket">
    <section class="w-full md:w-60 min-w-60 flex flex-col gap-2 md:gap-5">
        @foreach ($buttons as $tab => $label)
            <x-button.my
                wire:click="setTab('{{ $tab }}')"
                class="!justify-start"
                :outline="$selectedTab !== $tab"
                wire:loading.class="opacity-80 cursor-wait animate-pulse">
                {{ $label }}
            </x-button.my>
        @endforeach
    </section>
    <section class="w-full">
        @if ($selectedTab === 'details')
            <table class="w-full">
                <tbody>
                    @if (ticket()->status === App\Enums\Ticket\Status::Resolution || ticket()->status === App\Enums\Ticket\Status::Close)
                        <tr>
                            <th>
                                <p class="my-2 text-left">{{ __('Calificar soporte') }}</p>
                            </th>
                            <td>
                                <livewire:ticket.qualify />
                            </td>
                        </tr>
                    @endif
                    <tr>
                        <th>
                            <p class="my-2 text-left">{{ __('ID del ticket') }}</p>
                        </th>
                        <td>{{ ticket()->id }}</td>
                    </tr>
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
                        <td>
                            <x-badge
                                md
                                :color="ticket()->status->getColor()"
                                :label="ticket()->status->getLabel()" />
                        </td>
                    </tr>
                    @if (ticket()->diagnosis_date)
                        <tr>
                            <th class="text-left">
                                <p class="my-2 min-w-44">
                                    {{ __('Fecha de diagnóstico') }}
                                </p>
                            </th>
                            <td>{{ ticket()->diagnosis_date ? ticket()->diagnosis_date->format('d/m/Y') : __('Sin fechar de diagnostico') }}</td>
                        </tr>
                        <tr>
                            <th class="text-left">{{ __('Diagnóstico del técnico') }}</th>
                            <td>
                                <p class="my-2 text-sm">
                                    {{ ticket()->diagnosis_detail }}
                                </p>
                            </td>
                        </tr>
                    @endif
                    <tr>
                        <th class="text-left">{{ __('Articulo') }}</th>
                        <td>
                            <p class="my-2 text-sm">
                                {{ serviceCall()->itemName }}
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <th class="text-left">{{ __('Diagnostico ATC') }}</th>
                        <td>
                            <p class="my-2 text-sm">
                                {{ serviceCall()->subject }}
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <th class="text-left">{{ __('Dirección') }}</th>
                        <td>
                            <p class="my-2 text-sm">
                                {{ trim(serviceCall()->Location) }}
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <livewire:ticket.address />
                        </td>
                    </tr>
                </tbody>
            </table>
        @elseif($selectedTab === 'visits')
            <div>
                <section class="flex items-center justify-center gap-3">
                    <x-button outline primary x-on:click="displayCalendarMode = 'calendar'" label="{{ __('Modo calendario') }}" />
                    <x-button outline primary x-on:click="displayCalendarMode = 'list'" label="{{ __('Ver listado') }}" />
                </section>
                <livewire:ticket.calendar :visits="$visits" />
                <ul class="pt-6" x-show="displayCalendarMode === 'list'">
                    @forelse ($visits as $visit)
                        <li class="block w-full bg-slate-100 rounded-xl p-3 mb-6">
                            <div class="flex items-center justify-between">
                                <h3 class="font-semibold">{{ $visit->title }}</h3>
                                <p class="text-sm text-gray-500 font-semibold">{{ $visit->visit_date->format('d/m/Y H:i') }}</p>
                            </div>
                            <p class="text-sm my-3">{{ $visit->observation }}</p>
                            @if ($visit->reprogramming && count($visit->reprogramming))
                                @foreach ($visit->reprogramming as $key => $reprogramming)
                                    <h2 class="font-semibold my-3">
                                        <span>{{ __('Reprogramaciones hechas por ') }}</span>
                                        @php
                                            echo match ($key) {
                                                'client' => 'el cliente',
                                                'technical' => 'el técnico',
                                                default => 'otro motivo',
                                            };
                                        @endphp<span>:</span>
                                    </h2>
                                    <ul>
                                        @foreach ($visit->reprogramming['client'] as $reprogramming)
                                            <li class="text-sm grid grid-cols-2 border-t pt-2">
                                                <p><span class="font-semibold">Motivo: </span>{{ $reprogramming['extend_reason'] }}</p>
                                                <div>
                                                    <p>Fecha previa: {{ now()->parse($reprogramming['old_date'])->format('d/m/Y') }}</p>
                                                    <p>Fecha nueva: {{ now()->parse($reprogramming['new_date'])->format('d/m/Y') }}</p>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endforeach
                            @endif
                            @if ($visit->media->count())
                                <div class="flex items-center gap-3 mt-3 pt-4 border-t list-media-images" x-ref="list_images">
                                    @foreach ($visit->media as $media)
                                        <a href="{{ $media->original_url }}" x-on:click.prevent="openImage('{{ $media->original_url }}')">
                                            <img class="w-20 rounded-lg" src="{{ $media->original_url }}" alt="{{ $media->name }}" />
                                        </a>
                                    @endforeach
                                </div>
                            @endif
                        </li>
                    @empty
                        <div class="flex items-center justify-center flex-col py-6">
                            <x-icon name="bookmark-slash" class="w-12 h-12" outline />
                            <h3 class="text-center font-semibold text-secondary-100 text-xl py-3">{{ __('El técnico aun no ha pautado visitas.') }}</h3>
                        </div>
                    @endforelse
                </ul>
                <div
                    class="fixed bg-black/40 w-full h-full flex items-center justify-center top-0 left-0 z-70"
                    x-show="urlDisplayImg"
                    x-transition
                    x-on:click="urlDisplayImg = null">
                    <div class="w-[99vw] md:w-[80vw] h-[80vh]">
                        <img :src="urlDisplayImg" alt="" class="rounded-lg overflow-hidden">
                    </div>
                </div>
            </div>
        @elseif($selectedTab === 'comments')
            <livewire:comment />
        @endif
    </section>
    @script
        <script>
            Echo.channel(`App.Models.Ticket.{{ ticket()->id }}`)
                .listen('NewComment', (e) => {
                    console.log('Recibiendo nuevo comentario', {
                        e
                    });
                    $wire.dispatch('new-comment');
                });
        </script>
    @endscript
</main>
