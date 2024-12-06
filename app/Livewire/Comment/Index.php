<?php

namespace App\Livewire\Comment;

use App\Models\Comment;
use App\Models\Ticket;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Index extends Component
{
    /**
     * Comentarios
     *
     * @var array
     */
    public array $comments = [];

    /**
     * Comentario
     *
     * @var string
     */
    #[Validate('required')]
    public string $comment = '';

    /**
     * Mount
     *
     * @return void
     */
    public function mount(): void
    {
        $this->comments = Ticket::current()->comments()->get()->toArray();
    }

    /**
     * Enviar nuevo comentario
     *
     * @return void
     */
    public function send(): void
    {
        $this->validate(
            messages: [
                'comment.required' => __('No puede enviar comentarios vacíos'),
            ],
        );

        Ticket::current()->comments()->create([
            'comment' => $this->comment,
        ]);

        $this->comments[] = [
            'comment' => $this->comment,
            'created_at' => now(),
            'commentator_type' => '',
            'commentator_id' => '',
        ];

        $this->comment = '';
    }

    /**
     * Render
     *
     * @return void
     */
    public function render()
    {
        return <<<'BLADE'
            <section>
                <ul class="rounded-xl h-[65vh] max-h-[65vh] text-sm overflow-auto" wire:poll.10s>
                    @foreach($comments as $comment)
                        <li
                            class="mb-4"
                        >
                            <div
                                class="w-fit max-w-72 p-3 rounded-xl bg-secondary-200"
                            >
                                {{ $comment['comment'] }}
                            </div>
                        </li>
                    @endforeach
                </ul>
                <form class="mt-2 flex flex-wrap md:flex-nowrap items-start gap-3" wire:submit="send">
                    <x-textarea
                        placeholder="{{ __('Deja tu comentario con el servicio técnico') }}"
                        class="w-full md:w-11/12"
                        wire:model="comment"
                    />
                    <x-button
                        primary
                        type="submit"
                        label="{{ __('Enviar') }}"
                        class="w-full md:w-auto font-bold !text-secondary-100"
                    />
                </form>
            </section>
        BLADE;
    }
}
