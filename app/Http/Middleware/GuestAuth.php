<?php


namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Auth\GenericUser;
use Ramsey\Uuid\Uuid;
use Session;

class GuestAuth
{
    public function handle($request, Closure $next)
    {
        if(!Session::has('generic_user') || empty(Session::get('generic_user')) || !Session::get('generic_user')->{'realUser'} !== !Auth::check()){
            $user = Auth::check() ? Auth::user() : new GenericUser(['id' => Uuid::uuid4()->toString()]);
            $user->{'realUser'} = Auth::check();
            Session::put('generic_user', $user);
        }else{
            $user = Session::get('generic_user');
        }

        request()->setUserResolver(function () use ($user) {
            return $user;
        });
        return $next($request);
    }
}
