<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Models\Comment;
use App\Models\UserList;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function getUsersFromDB(){
        return redirect('/home');
    }

    public function index()
    {
        //$users = \App\Models\Comment::all();
        $users = (new \App\Models\UserList)->getUserList();
        return view('home', compact('users'));
    }
}
