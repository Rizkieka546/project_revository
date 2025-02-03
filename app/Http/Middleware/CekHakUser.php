<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CekHakUser
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect('/login')->withErrors(['auth' => 'Silakan login terlebih dahulu.']);
        }

        if (!in_array(Auth::user()->user_hak, $roles)) {
            return redirect()->route('unauthorized')->withErrors(['access' => 'Anda tidak memiliki akses ke halaman ini.']);
        }

        return $next($request);
    }
}
