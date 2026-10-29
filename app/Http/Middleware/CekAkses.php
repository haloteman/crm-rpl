<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CekAkses
{
    public function handle(Request $request, Closure $next)
    {
        $halaman = $request->route()->getName();

        if (! $request->user()->bolehAkses($halaman)) {
            abort(403);
        }

        return $next($request);
    }
}
