<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Models\User;

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
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreBookRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBookRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function show(Book $book, $userId)
    {
        $books = Book::where('author_id', $userId)->get();
        return view('profile.readbook', compact('books'));
    }

    /**
     * Show the form for editing the specified resource.
     *
//     * @param  \App\Models\Book  $book
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit($userId)
    {
        $book = Book::where('author_id', $userId)->first();
        return view('profile.editbook', compact('book'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateBookRequest  $request
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function update(UpdateBookRequest $request,$userId)
    {
        $request->validate([
            'id' => 'required',
            'name' => 'required',
            'text' => 'required',
        ]);
        $id = $request->input('id');
        $name = $request->input('name');
        $text = $request->input('text');
        Book::where('id', $id)->where('author_id',$userId)->update(['name' => $name, 'text' => $text]);

        $book = Book::where('author_id', $userId)->first();
        return view('profile.editbook', compact('book'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book)
    {
        //
    }
}
