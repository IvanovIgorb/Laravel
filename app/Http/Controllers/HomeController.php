<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Models\Comment;
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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function insertInDB(PostRequest $req){
        $text = $req->test;
//        return Comment::create([
//                'author_id' => '11',
//                'parent_id' => '1',
//                'comment' => 'But, is this working?',
//            ]);
        return "hello";


    }

    public function index()
    {
        //$users = \App\Models\Comment::all();

        $comm =new Comment();
        $comments = $comm->getComment();
        return view('home',compact('comments'));
    }
}
