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
     * Refrescar los comentarios para comprobar nuevos
     *
     * @return void
     */
    public function refreshComments(): void
    {
        $this->comments = Ticket::current()->comments()->get()->toArray();
        $this->dispatch('miEvento');
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
        return view('livewire.comment.index');
    }
}
