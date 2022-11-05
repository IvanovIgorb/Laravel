<?php

namespace App\Http\Controllers;

use App\Jobs\PostComment;
use App\Models\Access;
use App\Models\Comment;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class CommentController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function store(Request $request){

        $id = $request->input('userId');
        $text = $request->input('text');
        $title = $request->input('title');
        $author = $request->input('authorId');

        if ($request->has('parent')){
            $parent = $request->input('parent');
        }
        else{
            $parent = "0";
        }

        if($author == Auth::id()){
            Comment::create([
                'author_id' => $author,
                'host_user_id' => $id,
                'parent_id' => $parent,
                'title' => $title,
                'text' => $text,
            ]);
        }

        return redirect()->route('profile.index', ['userId' => $id]);
    }

    public function index($userId){
        $access = Access::where('user_id',$userId)->where('host_id', Auth::id())->first();
        if (isset($access)){
            $access = 1;
        }
        else{
            $access = 0;
        }
        $user = User::where('id',$userId)->first();
        $comments = Comment::join('users', 'users.id', '=', 'comments.author_id')
            ->leftJoin('comments AS c2', 'comments.parent_id', '=', 'c2.id')
            ->select('comments.*', 'users.name', 'c2.text as parent_text')
            ->where('comments.host_user_id',$userId)
            ->get();
        $count = count($comments);
        $comments = $comments->take(5);
        if (Auth::check()){
            foreach ($comments as $comment){
                if ($user->id == Auth::user()->id || Auth::user()->id == $comment->author_id){
                    $comment['permission'] = '1';
                }else{
                    $comment['permission'] = '0';
                };
            }
        }
        return view('profile.index', compact('user','comments', 'count', 'access'));
    }

    public function getMoreComments($userId){
        $user = User::where('id',$userId)->first();

        $comments = Comment::join('users', 'users.id', '=', 'comments.author_id')
            ->leftJoin('comments AS c2', 'comments.parent_id', '=', 'c2.id')
            ->select('comments.*', 'users.name', 'c2.text as parent_text')
            ->where('comments.host_user_id',$userId)
            //->skip(5)
            //->take(5)
            ->get();
        $count = count($comments) - 5;

        $comments = $comments->skip(5)
            ->take($count);
        foreach ($comments as $comment) {
            if ($user->id == Auth::user()->id || Auth::user()->id == $comment->author_id) {
                $comment['permission'] = '1';
            } else {
                $comment['permission'] = '0';
            };
        }

        //$comments = Comment::all();
        return response()->json([
            'user'=>$user,
            'comments'=>$comments,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        $userId = $request->input('userId');
        $commentId = $request->input('commId');
        $comment = Comment::where('id', $commentId)->first();
        if($userId == Auth::user()->id || Auth::user()->id == $comment->author_id)
            $comment->delete();
        return redirect()->route('profile.index', ['userId' => $userId]);
    }
}
