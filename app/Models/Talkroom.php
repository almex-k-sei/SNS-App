<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Talkroom extends Model
{
    use HasFactory;

    /* トークルームには複数のユーザーが所属 */
    public function user(){
        return $this->belongsToMany(User::class);
    }

    /* トークルームは複数のメッセージを所有 */
    public function message(){
        return $this->hasMany(Message::class);
    }
}
