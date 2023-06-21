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
        
        // dd($profiles);
        
        // $keyword = $request->input('keyword');
        // $follows = new User();
        $user = User::where('id','=',$user_id)
        ->get();
        // $friends = $user->follows;
        // dd($friends);
        $keyword = "あ";
        // if(Str::length($keyword)>0){
        //     $all_friends = 

        return view('/home',compact('keyword','profiles','user'));

    }

}
