<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use http\Client\Curl\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function postComment(Request $request){

        $text = $request->input('text');
        $title = $request->input('title');
        $author = $request->input('authorId');
        $id = $request->input('userId');

        (new \App\Models\Comment)->insertInDb($author,$id,$title,$text);

        return redirect()->route('profile.index', ['username' => $id]);
    }

    public function getProfile($username){
        $user = \App\Models\User::where('id',$username)->first();
        $comm =new Comment();
        $comments = $comm->getComment($username);
        return view('profile.index', compact('user','comments'));
    }

}
