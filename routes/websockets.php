<?php

use BeyondCode\LaravelWebSockets\Http\Controllers\WebSocketsController;

Broadcast::routes(['middleware' => [ 'web', 'auth', 'broadcast', 'pusher'], 'prefix' => 'app/websockets' ]);