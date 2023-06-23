<?php

namespace App\Http\Controllers;

use App\Models\Talkroom;
use App\Models\User;
use Illuminate\Console\View\Components\Task;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GroupListController extends Controller


{
    /* メッセージの一覧（トークルーム一覧）画面を表示する */
    public function index(Request $request)
    {
        /* ログインしているユーザーが所属しているトークルームの一覧を取得 */
        $all_users = User::all();
        $user_id = Auth::id();
        $user = User::where('id', $user_id)->first();
        $talkrooms = $user->talkroom;
        $groups = [];
        foreach ($talkrooms as $talkroom) {
            if (count($talkroom->user) > 1) {
                array_push($groups, $talkroom);
            }
        }

        $keyword = $request->input('keyword');
        /* 検索キーワードが入力されている場合、表示するデータを絞り込む */
        if (Str::length($keyword) > 0) {
            $groups = $groups[0]->where('name', 'LIKE', "%$keyword%")->get();
        }

        return view('group_list', compact('groups','all_users'));
    }

    public function add(Request $request)
    {
        /* バリデーション */

        $request->validate(
            [
            'name' => 'required|max:20',
            'member[]' => 'required|max:1000',
            ],
            [
                'name.required' => 'グループ名を入力してください',
                'name.max' => '文字数が多すぎます',
                'member[].required' => 'メンバーを入力してください',
                'member[].max' => '人数が多すぎます'
            ]
        );

        /* formで送信された内容をメッセージテーブルのレコードとして作成 */
        $group_table = new Talkroom();

        $group_table->name = $request->name;

        if (isset($request->image)) {
            $group_table->image = $request->image->store('groupdata', 'public');
        }
        /* データベースにレコードを追加する */

        dd($request->member);

        $group_table->save();

        return redirect('/GroupList');
    }
}
