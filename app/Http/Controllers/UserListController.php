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
        //ログイン情報から自分のプロフィールを取得→表示
        $user_id = Auth::id();
        $profiles = Profile::where('user_id','=',$user_id)
        ->get();
        //フレンドを取得→表示
        $user = User::find($user_id);
        $friends = $user->follows;
        //フレンド検索機能
        $keyword = $request->input('keyword');
        if($keyword !== null ){
                $friends = $user->follows()->where('name','LIKE',"%$keyword%")->get();
                // ->orWhere('birth','LIKE',"%$keyword%")->orwhere('description','LIKE',"%$keyword%")->get();
        }

        return view('/home',compact('keyword','profiles','friends'));

    }

}
