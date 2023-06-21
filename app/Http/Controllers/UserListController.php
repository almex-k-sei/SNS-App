<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class UserListController extends Controller
{
    //ホーム画面表示
    public function index(Request $request){
        $user_id = Auth::id();
        $profiles = Profile::where('user_id','=',$user_id)
        ->get();
        $user = User::find($user_id);
        $friends = $user->follows;
        // dd($friends);
        $keyword = "あ";

        return view('/home',compact('keyword','profiles','friends'));

    }

}
