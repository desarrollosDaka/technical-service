<?php

namespace App\Enums\Media;

enum MediaModel: string
{
    case Ticket = \App\Models\Ticket::class;
    case Visit = \App\Models\TechnicalVisit::class;
    case PartRequest = \App\Models\PartRequest::class;
}
