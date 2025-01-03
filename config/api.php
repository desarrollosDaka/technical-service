<?php

return [
    /**
     * Backend to Backend Token,
     * used for backend to backend communication.
     */
    'b_b_token' => env('B_B_TOKEN', 1234),

    /**
     * Habilitar las notificaciones OneSignal
     */
    'one_signal_notifications' => (bool) env('ONE_SIGNAL_NOTIFICATIONS', false),
];
