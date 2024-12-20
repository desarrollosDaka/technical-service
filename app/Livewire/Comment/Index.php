<?php

namespace App\Livewire\Comment;

use App\Events\NewComment;
use App\Models\Comment;
use App\Models\Ticket;
use Livewire\Attributes\On;
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
    #[On('new-comment')]
    public function refreshComments(): void
    {
        if (!Ticket::current()) {
            redirect('/');
            return;
        }
        $this->comments = Ticket::current()->comments()->get()->toArray();
        $this->dispatch('refreshedComment');
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

        $ticketCreated = Ticket::current()->comments()->create([
            'comment' => $this->comment,
        ]);

        $this->comments[] = [
            'comment' => $this->comment,
            'created_at' => now(),
            'commentator_type' => '',
            'commentator_id' => '',
        ];

        NewComment::dispatch(Ticket::current(), $ticketCreated);

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
