<main class="flex flex-wrap md:flex-nowrap gap-4" x-data="{ displayCalendarMode: 'calendar' }">
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
                    @if (ticket()->status === App\Enums\Ticket\Status::Close)
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
                        <td>{{ ticket()->status->getLabel() }}</td>
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
                            <th class="text-left">{{ __('Diagnóstico') }}</th>
                            <td>
                                <p class="my-2 text-sm">
                                    {{ ticket()->diagnosis_detail }}
                                </p>
                            </td>
                        </tr>
                    @endif
                    <tr>
                        <td class="text-left" colspan="2">{{ __('Dirección') }}</td>
                        <td>{{ serviceCall()->Location }}</td>
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
                    @foreach ($visits as $visit)
                        <li class="block w-full bg-slate-100 rounded-xl p-3 mb-6">
                            <h3 class="font-semibold">{{ $visit->title }}</h3>
                            <p class="text-sm text-gray-600">{{ $visit->visit_date->format('d/m/Y') }}</p>
                            <p class="text-sm mt-3">{{ $visit->observations }}</p>
                            <div class="flex items-center gap-3 mt-3 pt-4 border-t">
                                <img class="w-20 rounded-lg" src="{{ asset('img/placeholder.com-1280x720.webp') }}" alt="">
                                <img class="w-20 rounded-lg" src="{{ asset('img/placeholder.com-1280x720.webp') }}" alt="">
                                <img class="w-20 rounded-lg" src="{{ asset('img/placeholder.com-1280x720.webp') }}" alt="">
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        @elseif($selectedTab === 'comments')
            <livewire:comment />
        @endif
    </section>
    @script
        <script>
            Echo.channel(`App.Models.Ticket.{{ ticket()->id }}`)
                .listen('NewComment', (e) => {
                    $wire.dispatch('new-comment');
                });
        </script>
    @endscript
</main>
