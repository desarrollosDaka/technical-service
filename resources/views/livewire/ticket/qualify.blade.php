<div x-data="{ star: $wire.entangle('star'), startOnHover: 0, hasEditable: {{ (bool) $previousQualify ? 'false' : 'true' }} }">
    @unless ($previousQualify)
        <x-button outline primary label="{{ __('Danos tus comentarios') }}" x-on:click="$openModal('qualification')" />
    @else
        <x-button light secondary label="{{ __('Ver mi calificación') }}" x-on:click="$openModal('qualification')" />
    @endunless

    <x-modal name="qualification" title="{{ __('Calificar soporte') }}">
        <x-card title="{{ __('Calificar soporte') }}" with='xl'>
            <p class="text-neutral-600 text-sm md:max-w-[65%] text-center mx-auto mb-6">¡{{ __('Para tiendas DAKA es importante conocer tu opinion de nuestro servicio técnico') }}!</p>

            <div class="flex items-center flex-col mb-4">
                <div class="flex justify-center items-center">
                    <template x-for="i in 5">
                        <div
                            class="text-primary-100 cursor-pointer px-2"
                            x-bind:class="{ 'text-secondary-100': i <= (startOnHover || star) }"
                            x-on:mouseover="() => {
                                if(hasEditable) {
                                    startOnHover = i;
                                }
                            }"
                            x-on:mouseleave="() => {
                                if(hasEditable) {
                                    startOnHover = 0;
                                }
                            }"
                            x-on:click="() => {
                                if(hasEditable) {
                                    star = i;
                                }
                            }">
                            <x-icon name="star" class="w-10 h-10" />
                        </div>
                    </template>
                </div>
                <div class="text-secondary-100 font-semibold">
                    <p x-show="(startOnHover || star) === 0">¿{{ __('Como calificas el soporte obtenido') }}?</p>
                    <p x-show="(startOnHover || star) === 1">{{ __('Malo') }}</p>
                    <p x-show="(startOnHover || star) === 2">{{ __('Mejorable') }}</p>
                    <p x-show="(startOnHover || star) === 3">{{ __('Regular') }}</p>
                    <p x-show="(startOnHover || star) === 4">{{ __('Bueno') }}</p>
                    <p x-show="(startOnHover || star) === 5">{{ __('¡Excelente!') }}</p>
                </div>
                @error('star')
                    <x-alert title="{{ __('Por favor, dale aunque sea una estrella 😢😢.') }}" negative flat class="mt-4" />
                @enderror
            </div>

            {{-- Listado de visitas --}}
            @if (count($services))
                <h2 class="text-center font-semibold mb-2 text-sm text-slate-700">{{ __('Visitas del técnico') }}</h2>
                <ul>
                    @foreach ($services as $service)
                        <li class="flex items-center justify-between text-sm border-b pb-3 mb-3">
                            <div>
                                <p>{{ $service['repuestos'] }}</p>
                                <p class="text-gray-400">Producto: {{ $service['producto'] }}</p>
                            </div>
                            <div>
                                <x-toggle
                                    rounded="sm"
                                    label="{{ __('¿Servicio fue realizado?') }}"
                                    wire:model="confirmed_services.{{ $service['n'] }}"
                                    :disabled="(bool) $previousQualify"
                                    xl />
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif

            <x-textarea :disabled="(bool) $previousQualify" placeholder="{{ __('¿Como fue tu experiencia? ¡Cuéntanos!') }}" wire:model="comment" />

            @if ($previousQualify)
                <x-alert title="{{ __('¡Gracias por tu calificación!') }}" positive flat class="mt-4" />
            @endif

            @unless ($previousQualify)
                <x-slot name="footer" class="flex justify-end gap-x-4">
                    <x-button flat label="{{ __('Cancelar') }}" x-on:click="close" />
                    <x-button primary label="{{ __('Confirmar') }}" wire:click="send" />
                </x-slot>
            @endunless
        </x-card>
    </x-modal>
</div>
