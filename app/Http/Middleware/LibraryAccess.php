<?php

namespace App\Http\Middleware;

use App\Models\Access;
use App\Models\Book;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LibraryAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $hostId = $request->route('userId');
        $userId = Auth::id();
        $access = Access::where('host_id', $hostId)->where('user_id', $userId)->first();
        if (isset($access) || $userId == $hostId) {
            return $next($request);
        } else {
            abort(403);
        }
    }
}