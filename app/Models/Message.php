<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    /* メッセージは一人のユーザーに所属 */
    public function user(){
        return $this->belongsTo(User::class);
    }

    /* メッセージは一つのトークルームに所属 */
    public function talkroom(){
        return $this->belongsTo(Talkroom::class);
    }
}
