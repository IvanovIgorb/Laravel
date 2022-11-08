<?php

namespace App\Http\Middleware;

use App\Models\Access;
use App\Models\Book;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookAccess
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

        $userId = $request->route('userId');
        $bookId = $request->route('bookId');

        $access = Access::where('user_id', Auth::id())->where('host_id', $userId)->first();
        $book = Book::where('id', $bookId)->where('author_id', $userId)->first();
        if (isset($book)) {
            if ($book->access == 1 || $book->author_id == Auth::id() || isset($access)) {
                return $next($request);
            } else {
                abort(403);
            }
        } else {
            abort(404);
        }

    }
}