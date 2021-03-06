<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

/**
中間件處理已登録授權跳轉
**/
class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            $message = $request->is('signup') ? '您已注册并且登录' : '您已登录，无需再次操作。';
            session()->flash('info', $message);
            return redirect('/');
        }

        return $next($request);
    }
}
