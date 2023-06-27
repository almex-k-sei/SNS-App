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
        //友達追加の初期値
            $results =(object)"";
            $results->image = "https://beiz.jp/images_T/white/white_00081.jpg";
            $results->name = "友達を追加しましょう!";

          //友達候補検索機能
          if(isset($_GET['search_friend'])){
                $users= User::all();
                if($request->input('friend_email') !== null ){
                    $friend_email = $request->input('friend_email');
                    $user = $users->where('email','=',"%$friend_email%")
                    ->first();
                }
                    if($user !== null){
                    $user_id = $user->id;
                    $results = Profile::where('id','=',"$user_id")->first();
                }
          }

        return view('home',compact('keyword', 'profiles', 'friends', 'user_id','results'));

    }
    public function edit(Request $request){
        $user_id = Auth::id();
        $user = Profile::where('user_id','=',$user_id)->first();
        if($request->input("name") !==null){
        $user->name = $request->input("name");
        }
        if($request->input("description") !==null){
        $user->description = $request->input("description");
        }
        if($request->input("birthday") !==null){
        $user->birth = $request->input("birthday");
        }
        if($request->input("url") !==null){
            $user->image = $request->input("url");
        }
        $user->save();
        return redirect('/home');

    }

}
