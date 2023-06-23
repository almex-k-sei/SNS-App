<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GroupListController extends Controller


{
    /* メッセージの一覧（トークルーム一覧）画面を表示する */
    public function index(Request $request)
    {
        /* ログインしているユーザーが所属しているトークルームの一覧を取得 */
        $user_id = Auth::id();
        $user = User::where('id', $user_id)->first();
        $talkrooms = $user->talkroom;
        $groups = [];
        foreach ($talkrooms as $talkroom) {
            if (count($talkroom->user) > 1) {
                array_push($groups, $talkroom);
            }
        }
        return view('group_list', compact('groups'));
    }
}
