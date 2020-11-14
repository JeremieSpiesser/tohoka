<?php

use App\Models\User;
use App\Utils;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Session;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('public_room', function ($user) {
    if(!User::isRegistered($user)) {
        if(!Session::has('chat_name')){
            Session::put('chat_name', 'Guest: ' . Utils::randomName());
        }
        $user->name = Session::get('chat_name');
    }

    //Log::info('User: ' . print_r($user, true));

    return ['id' => $user->id, 'name' => $user->name];
});
