<?php

namespace App\Http\Middleware;

use Closure;

use Illuminate\Support\Facades\Auth;

class User
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $id = session("id");
        $type = session("type");
        if (!$id) {
            return redirect()->route("login");
        } else {
            if ($type != "user") {
                // Reseteamos sesión
                $request->session()->flush();
                return redirect()->route("login");
            }
        }

        return $next($request);
    }
}
