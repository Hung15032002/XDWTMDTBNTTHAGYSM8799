<?php

// namespace App\Http\Middleware;

// use Illuminate\Auth\Middleware\Authenticate as Middleware;

// class AdminAuthenticate extends Middleware
// {
//     /**
//      * Get the path the user should be redirected to when they are not authenticated.
//      */
//     protected function redirectTo($request): ?string
//     {
//         if (! $request->expectsJson()) {
//             return route('admin.login');
//         }

//         return null;
//     }

//     protected function authenticate($request, array $guards)
//     {
//         if ($this->auth->guard('admin')->check()) {
//             return $this->auth->shouldUse('admin');
//         }
//         $this->unauthenticated($request, ['admin']);
//     }
// }
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthenticate
{
    public function handle(Request $request, Closure $next)
    {
        // Kiểm tra xem người dùng có phải là admin và đã đăng nhập chưa
        if (Auth::guard('admin')->check()) {
            return $next($request);
        }

        // Nếu không phải admin, chuyển hướng tới trang login
        return redirect()->route('admin.login');
    }
}