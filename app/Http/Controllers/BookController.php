<?php

namespace App\Http\Controllers;

use App\Models\Access;
use App\Models\Book;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Ramsey\Uuid\Type\Integer;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index($userId)
    {
        $user = User::where('id', $userId)->first();
        $books = Book::where('author_id', $userId)->get();
        return view('profile.library', compact('books', 'user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('profile.createBook');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreBookRequest $request
     * @return RedirectResponse
     */
    public function store(StoreBookRequest $request)
    {
        $request->validate(
            [
                'name' => 'required|max:100',
                'text' => 'required',
            ]
        );

        $name = $request->input('name');
        $text = $request->input('text');
        $authorId = Auth::id();

        Book::create(
            [
                'name' => $name,
                'text' => $text,
                'author_id' => $authorId,
            ]
        );

        return redirect()->route('profile.library', ['userId' => $authorId]);
    }

    /**
     * Display the specified resource.
     *
     * @param $bookId
     * @return Application|Factory|View
     */
    public function show($bookId)
    {
        $book = Book::where('id', $bookId)->first();
        return view('profile.readBook', compact('book'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return Application|Factory|View
     */
    public function edit($userId, $bookId)
    {
        $book = Book::where('author_id', $userId)->where('id', $bookId)->first();

        if (isset($book)) {
            return view('profile.editBook', compact('book'));
        } else {
            abort(404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateBookRequest $request
     * @param $userId
     * @return RedirectResponse
     */
    public function update(UpdateBookRequest $request, $userId)
    {
        if ($request->has('accessUpdateToY')) {
            $request->validate(
                [
                    'id' => 'required',
                ]
            );
            $id = $request->input('id');
            if (Auth::id() == $userId)
                Book::where('id', $id)->where('author_id', $userId)->update(['access' => 1]);
            return redirect()->route('profile.library', ['userId' => $userId]);
        } elseif ($request->has('accessUpdateToN')) {
            $request->validate(
                [
                    'id' => 'required',
                ]
            );
            $id = $request->input('id');
            if (Auth::id() == $userId)
                Book::where('id', $id)->where('author_id', $userId)->update(['access' => 0]);
            return redirect()->route('profile.library', ['userId' => $userId]);
        } else {
            $request->validate(
                [
                    'id' => 'required',
                    'name' => 'required',
                    'text' => 'required',
                ]
            );
            $id = $request->input('id');
            $name = $request->input('name');
            $text = $request->input('text');
            if (Auth::id() == $userId)
                Book::where('id', $id)->where('author_id', $userId)->update(['name' => $name, 'text' => $text]);
            return redirect()->route('profile.editBook', ['userId' => $userId, 'bookId' => $id]);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param StoreBookRequest $request
     * @return RedirectResponse
     */
    public function destroy(StoreBookRequest $request)
    {
        $authorId = Auth::id();
        $bookId = $request->input('id');
        $book = Book::where('id', $bookId)->where('author_id', $authorId)->first();
        if ($authorId == $book->author_id)
            $book->delete();
        return redirect()->route('profile.library', ['userId' => $authorId]);
    }
}