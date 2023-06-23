<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profile;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
class UserController extends Controller
{
    //新規登録時にプロフィール追加+usersテーブルとprofilesテーブルを結び付ける
    public function create(Request $request){
        $new_profile = new Profile();
        if($request->name !== null){
            $new_profile->name = $request->name;
        }elseif($request->name == null){
            $new_profile->name = Auth::user()->name;
        }
        if($request->image !== null){
            $new_profile->image = $request->image;
        }elseif($request->image == null){
            $new_profile->image = "https://www.google.com/url?sa=i&url=https%3A%2F%2Ffrigater.com%2Fnews%2F5954&psig=AOvVaw1Ms-qnln10lu78k8aWqOzE&ust=1687586792176000&source=images&cd=vfe&ved=0CBEQjRxqFwoTCNico-7c2P8CFQAAAAAdAAAAABAD";
        }
        if($request->name !== null){
            $new_profile->birth = $request->birth;
        }elseif($request->birth == null){
            $new_profile->birth = "非公開";
        }
        if($request->description !== null){
            $new_profile->description = $request->description;
        }elseif($request->description == null){
            $new_profile->description = "よろしくお願いします";
        }
        $new_profile->user_id = Auth::id();
        $new_profile->save();
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

        return view('/home');
    }


}
    