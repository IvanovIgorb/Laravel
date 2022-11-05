<?php

namespace App\Http\Controllers;

use App\Models\Access;
use App\Models\Book;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccessController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index($userId)
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreBookRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'id' => 'required',
        ]);

        $userId = $request->input('id');
        $hostId = Auth::id();

        Access::create([
            'host_id' => $hostId,
            'user_id' => $userId
        ]);

        return redirect()->route('profile.index', ['userId' => $userId]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        $hostId = Auth::id();
        $userId = $request->input('id');

        Access::where('user_id',$userId)->where('host_id', $hostId)->delete();

        return redirect()->route('profile.index', ['userId' => $userId]);
    }
}
