<?php

namespace App\Http\Middleware;

use App\Models\Access;
use App\Models\Book;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookFunctionsAccess
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
        $userId = Auth::id();
        $bookId = $request->route('bookId');
        $book = Book::where('id',$bookId)->where('author_id', $userId)->first();
        if (isset($book)) {
            return $next($request);
        }
        else
            abort(403);

    }
}
