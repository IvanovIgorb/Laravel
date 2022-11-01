<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Comment extends Model
{
    use HasFactory;
    protected $guarded = false;

    public function insertInDB($author, $id, $title, $text,$parent){
        Comment::create([
            'author_id' => $author,
            'host_user_id' => $id,
            'parent_id' => $parent,
            'title' => $title,
            'text' => $text,
        ]);
    }

    public function deleteFromDB($commentId){
        $comm = DB::table('comments')->where('id', '=', $commentId)->delete();
        //$comm = Comment::where('id', $commentId)->delete();
    }
}
