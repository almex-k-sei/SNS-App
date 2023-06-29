<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Console\View\Components\Task;
use Illuminate\Support\Str;

class UserListController extends Controller
{
    //ホーム画面表示
    public function index(Request $request)
    {
        //ログイン情報から自分のプロフィールを取得→表示
        $user_id = Auth::id();
        $profiles = Profile::where('user_id', '=', $user_id)
            ->get();
        //フレンドを取得→表示
        $user = User::find($user_id);
        $friends = $user->follows;
        //フレンド検索機能
        $keyword = $request->input('keyword');
        if ($keyword !== null) {
            $friends = $user->follows()->where('name', 'LIKE', "%$keyword%")->get();
            // ->orWhere('birth','LIKE',"%$keyword%")->orwhere('description','LIKE',"%$keyword%")->get();
        }
        return view('home', compact('keyword', 'profiles', 'friends', 'user_id', 'user'));
    }

    public function search_index()
    {
        //友達追加の初期値
        $results = (object)"";
        $results->image = "https://icon-pit.com/wp-content/uploads/2018/10/question_mark_icon_1034.png";
        $results->name = "友達を追加しましょう!";
        $friend_id = "0";
        return view('search_friend', compact('results', "friend_id"));
    }

    public function search_friend(Request $request)
    {
        //友達候補検索機能
        //usersテーブルから全情報を抜き出し、email と合致するfriend候補を出す
        $users = User::all();
        $friend_email = $request->input('friend_email');
        $friend = $users->where('email', '=', "$friend_email")
            ->first();
        $user_id = Auth::id();
        $user = User::find($user_id);
        $results = (object)"";
        if ($friend !== null) { //合致する人がいたら
            $friend_id = $friend->id;
            foreach ($user->follows as $value) {
                //friendsテーブルのuser_id == Auth::id()　且つ　friendsテーブルのfriend_id == $friend_idのとき　→友達である
                if ($value->pivot->friend_id == $friend_id) {
                    $results->image = $value->profile->image;
                    $results->name = "すでに友達です";
                }
                if($user_id == $friend_id){
                    $results->image = $user->profile->image;
                    $results->name = "自分自身です";
                }
            }
            if ($results == (object)"") {
                $results = Profile::where("user_id", "=", "$friend_id")->first();
            }
        } else {
            $results = (object)"";
            $results->image = "https://icon-pit.com/wp-content/uploads/2018/10/question_mark_icon_1034.png";
            $results->name = "見つかりませんでした";
            $friend_id = "0";
        }
        return view('search_friend', compact('results', 'friend_id'));
    }

    public function add_friend(Request $request)
    {
        $id = Auth::id();
        $user = User::where("id", "=", "$id")->first();
        if($request->input("results") == "すでに友達です" || $request->input("results") == "見つかりませんでした"){
        }elseif($request->input("friend_id")){
            $friend_id = $request->input("friend_id");
            $user->follows()->attach($friend_id);
        }

        return redirect('Home');
    }



    public function edit(Request $request)
    {
        $user_id = Auth::id();
        $user = Profile::where('user_id', '=', $user_id)->first();
        if ($request->input("name") !== null) {
            $user->name = $request->input("name");
        }
        if ($request->input("description") !== null) {
            $user->description = $request->input("description");
        }
        if ($request->input("birthday") !== null) {
            $user->birth = $request->input("birthday");
        }
        if ($request->url !== null) {
            $user->image = $request->url->store('profiledata', 'public');
        }
        $user->save();
        return redirect('Home');
    }

    public function accept_request(Request $request)
    {
        $id = Auth::id();
        $user = User::where("id", "=", "$id")->first();
        $friend_id = $request->id;

        $user->follows()->attach($friend_id);

        return redirect('Home');
    }
}
