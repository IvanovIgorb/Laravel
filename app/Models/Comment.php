<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Comment extends Model
{
    use HasFactory;
    protected $guarded = false;

    public function getComment(): \Illuminate\Support\Collection
    {
        $data = DB::table('comments')
            ->join('users', 'users.id', '=', 'comments.author_id')
            ->select('comments.*', 'users.name')
            ->get();
        return $data;
    }
}
