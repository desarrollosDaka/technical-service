<section wire:poll.2s="refreshComments">
    <ul class="rounded-xl h-[65vh] max-h-[65vh] text-sm overflow-auto soft-scrollbar px-3">
        @foreach ($comments as $comment)
            <li
                @class(['mb-5 flex', 'justify-end' => !$comment['commentator_type']])>
                <div @class([
                    'w-fit min-w-32 max-w-72 p-3 rounded-xl relative',
                    'bg-secondary-200' => !$comment['commentator_type'],
                    'bg-primary-500 text-secondary-100' => $comment['commentator_type'],
                ])>
                    {{ $comment['comment'] }}
                    <span class="absolute -bottom-4 right-1 text-xs text-neutral-700">
                        {{ \Carbon\Carbon::parse($comment['created_at'])->diffForHumans() }}
                    </span>
                </div>
            </li>
        @endforeach
    </ul>
    <form class="mt-2 flex flex-wrap md:flex-nowrap items-start gap-3" wire:submit="send">
        <x-textarea
            placeholder="{{ __('Deja tu comentario con el servicio técnico') }}"
            class="w-full md:w-11/12"
            wire:model="comment" />
        <x-button
            primary
            type="submit"
            label="{{ __('Enviar') }}"
            class="w-full md:w-auto font-bold !text-secondary-100" />
    </form>
    @script
        <script>
            const commentsContainer = $wire.el.querySelector('ul');

            const scrollToBottom = () => {
                setTimeout(() => {
                    if (commentsContainer) {
                        commentsContainer.scrollTop = commentsContainer.scrollHeight;
                    }
                }, 200);
            }

            $wire.on('refreshedComment', () => {
                scrollToBottom();
            });
            scrollToBottom();
        </script>
    @endscript
</section>
