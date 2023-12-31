<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /* ユーザーは１つのプロフィールを所有 */
    public function profile(){
        return $this->hasOne(Profile::class);
    }

    /* ユーザーは複数のトークルームに所属 */
    public function talkroom(){
        return $this->belongsToMany(Talkroom::class);
    }

    /* ユーザーは複数のメッセージを所有 */
    public function message(){
        return $this->hasMany(Message::class);
    }

    /* friend機能 */
    public function follows(){
        return $this->belongsToMany(self::class, "friends", "user_id", "friend_id")
        ->withPivot('friend_id','user_id');
    }
    public function followers(){
        return $this->belongsToMany(self::class, "friends", "friend_id", "user_id");
    }

}
