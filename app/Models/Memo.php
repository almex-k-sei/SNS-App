<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Memo extends Model
{
    use HasFactory;

    /*  メモは一人のユーザーに所属 */
    public function user(){
        return $this->belongsTo(User::class);
    }

    /* メモは一つのトークルームに所属 */
    public function talkroom(){
        return $this->belongsTo(Talkroom::class);
    }
}
