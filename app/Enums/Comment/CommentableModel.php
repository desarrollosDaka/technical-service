<?php

namespace App\Enums\Comment;

use App\Models\Ticket;

enum CommentableModel: string
{
    case Ticket = Ticket::class;
}
