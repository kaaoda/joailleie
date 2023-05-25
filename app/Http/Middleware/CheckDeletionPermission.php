<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class CheckDeletionPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if($request->user() && $request->isMethod("DELETE"))
        {
            if($request->user()->role->canonical_name == "admin") return $next($request);
            else return abort(403, 'Not Allowed!');
        }
        return $next($request);
    }
}
