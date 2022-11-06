<?php

namespace App\Http\Controllers;

use App\Models\Access;
use App\Models\Book;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index($userId)
    {
        $user = User::where('id',$userId)->first();
        $books = Book::where('author_id', $userId)->get();
        return view('profile.library', compact('books','user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        return view('profile.createBook');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreBookRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreBookRequest $request)
    {
        $request->validate([
            'name' => 'required|max:100',
            'text' => 'required',
        ]);

        $name = $request->input('name');
        $text = $request->input('text');
        $authorId = Auth::id();

        Book::create([
            'name' => $name,
            'text' => $text,
            'author_id' => $authorId,
            'access' => 0
        ]);

        return redirect()->route('profile.library', ['userId' => $authorId]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function show(Book $book, $userId, $bookId)
    {
        $book = Book::where('id',$bookId)->first();
        return view('profile.readBook', compact('book'));
    }

    /**
     * Show the form for editing the specified resource.
     *
//     * @param  \App\Models\Book  $book
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit($userId, $bookId)
    {
        $book = Book::where('author_id', $userId)->where('id',$bookId)->first();

        if (isset($book)){
            return view('profile.editBook', compact('book'));
        }
        else {
            abort(404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateBookRequest  $request
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateBookRequest $request, $userId)
    {
        if ($request->has('accessUpdateToY')){
            $request->validate([
                'id' => 'required',
            ]);
            $id = $request->input('id');
            if (Auth::id() == $userId)
                Book::where('id', $id)->where('author_id',$userId)->update(['access' => 1]);
            return redirect()->route('profile.library', ['userId' => $userId]);
        }
        elseif ($request->has('accessUpdateToN')){
            $request->validate([
            'id' => 'required',
            ]);
            $id = $request->input('id');
            if (Auth::id() == $userId)
                Book::where('id', $id)->where('author_id',$userId)->update(['access' => 0]);
            return redirect()->route('profile.library', ['userId' => $userId]);
        }
        else{
            $request->validate([
                'id' => 'required',
                'name' => 'required',
                'text' => 'required',
            ]);
            $id = $request->input('id');
            $name = $request->input('name');
            $text = $request->input('text');
            if (Auth::id() == $userId)
                Book::where('id', $id)->where('author_id',$userId)->update(['name' => $name, 'text' => $text]);
            return redirect()->route('profile.editBook', ['userId' => $userId, 'bookId' => $id]);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(StoreBookRequest $request)
    {
        $authorId = Auth::id();
        $bookId = $request->input('id');
        $book = Book::where('id', $bookId)->where('author_id', $authorId)->first();
        if($authorId == $book->author_id)
            $book->delete();
        return redirect()->route('profile.library', ['userId' => $authorId]);
    }
}
