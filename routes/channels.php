<?php

use App\Utils;
use Illuminate\Auth\GenericUser;
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

Route::post('/broadcasting/auth', function (){
    $user = new GenericUser(['id' => microtime()]);

    request()->setUserResolver(function () use ($user) {
        return $user;
    });

    return Broadcast::auth(request());
});

Broadcast::channel('public_room', function ($user) {
    if(!Session::has('chat_name')){
        Session::put('chat_name', Utils::randomName());
    }

    Log::info("ID = ", Session::get('chat_name'));

    return ['id' => $user->id(), 'name' => Session::get('chat_name')];
});
