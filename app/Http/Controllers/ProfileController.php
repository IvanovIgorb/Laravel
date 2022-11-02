<?php

namespace App\Http\Controllers;

use App\Jobs\PostComment;
use App\Models\Comment;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ProfileController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function postComment(Request $request){

        $id = $request->input('userId');
        if ($request->has('send')) {

            $text = $request->input('text');
            $title = $request->input('title');
            $author = $request->input('authorId');

            if ($request->has('parent')){
                $parent = $request->input('parent');
            }
            else{
                $parent = "0";
            }
            Comment::create([
                'author_id' => $author,
                'host_user_id' => $id,
                'parent_id' => $parent,
                'title' => $title,
                'text' => $text,
            ]);
        } else
            if ($request->has('delete')) {
            $commentId = $request->input('commId');
            Comment::where('id', '=', $commentId)->delete();
        }
        //return 'no action found';

        return redirect()->route('profile.index', ['username' => $id]);
    }

    public function getProfile($username){
        $user = User::where('id',$username)->first();
        $comments = Comment::join('users', 'users.id', '=', 'comments.author_id')
            ->leftJoin('comments AS c2', 'comments.parent_id', '=', 'c2.id')
            ->select('comments.*', 'users.name', 'c2.text as parent_text')
            ->where('comments.host_user_id',$username)
            ->get();
        $count = count($comments);
        $comments = $comments->take(5);
        foreach ($comments as $comm){
            if ($user->id == Auth::user()->id || Auth::user()->id == $comm->author_id){
                $comm['permission'] = '1';
            }else{
                $comm['permission'] = '0';
            };
        }
        return view('profile.index', compact('user','comments', 'count'));
    }

    public function getMoreComments($username){
        $user = User::where('id',$username)->first();
        //$allComments = Comment::all();

        $comments = Comment::join('users', 'users.id', '=', 'comments.author_id')
            ->leftJoin('comments AS c2', 'comments.parent_id', '=', 'c2.id')
            ->select('comments.*', 'users.name', 'c2.text as parent_text')
            ->where('comments.host_user_id',$username)
            //->skip(5)
            //->take(5)
            ->get();
        $commcount = count($comments) - 5;

        $comments = $comments->skip(5)
            ->take($commcount);
        foreach ($comments as $comm) {
            if ($user->id == Auth::user()->id || Auth::user()->id == $comm->author_id) {
                $comm['permission'] = '1';
            } else {
                $comm['permission'] = '0';
            };
        }

        //$comments = Comment::all();
        return response()->json([
            'user'=>$user,
            'comments'=>$comments,
        ]);
    }

}
