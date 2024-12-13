<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Technical.{id}', function ($technical, $id) {
    return (int) $technical->id === (int) $id;
});

Broadcast::channel('App.Ticket.{id}', function () {
    return true;
});
