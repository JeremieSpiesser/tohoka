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

Broadcast::channel('playquizz.{id}', function ($user, $id) {
    if(!User::isRegistered($user)) {
        if(!Session::has('play_name')){
            Session::put('play_name', 'Guest: ' . Utils::randomName());
        }
        $user->name = Session::get('play_name');
    }

    return ['id' => $user->id, 'name' => $user->name, 'state' => 'En attente ...'];
});


Broadcast::channel('room.{id}', function ($user, $id) {
    if(!User::isRegistered($user)) {
        if(!Session::has('chat_name')){
            Session::put('chat_name', 'Guest: ' . Utils::randomName());
        }
        $user->name = Session::get('chat_name');
    }

    Session::put('current_room', $id);

    return ['id' => $user->id, 'name' => $user->name];
});
