<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class MessageListController extends Controller
{
    /* メッセージの一覧（トークルーム一覧）画面を表示する */
    public function index(Request $request)
    {
        /* ログインしているユーザーが所属しているトークルームの一覧を取得 */
        $user_id = Auth::id();
        $user = User::where('id', $user_id)->first();
        $talkrooms = $user->talkroom;

        /* キーワードを取得 */
        $keyword = $request->input('keyword');

        /* 検索キーワードが入力されている場合、表示するデータを絞り込む */
        if (Str::length($keyword) > 0) {
            $talkrooms = $talkrooms[0]->where('name', 'LIKE', "%$keyword%")->get();
        }

        return view('message_list', compact('talkrooms', 'keyword'));
    }
}
