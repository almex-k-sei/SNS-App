<?php

namespace App\Http\Controllers;

use App\Models\Talkroom;
use App\Models\User;
use Illuminate\Console\View\Components\Task;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class GroupListController extends Controller


{
    /* メッセージの一覧（トークルーム一覧）画面を表示する */
    public function index(Request $request)
    {
        /* ログインしているユーザーが所属しているトークルームの一覧を取得 */
        $user_id = Auth::id();
        $user = User::find($user_id);
        $all_friends = $user->follows;
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

        return view('group_list', compact('groups','all_friends'));
    }

    public function add(Request $request)
    {
        /* バリデーション */

        $request->validate(
            [
            'name' => 'required|max:20',
            'image' => 'image',
            'members' => 'required|min:3|max:1000',
            ],
            [
                'name.required' => 'グループ名を入力してください',
                'name.max' => '文字数が多すぎます',
                'image.image' => '画像ファイルを指定してください',
                'members.required' => 'メンバーを入力してください',
                'members.min' => '最低でも3人以上選択してください',
                'members.max' => '人数が多すぎます'
            ]
        );

        /* formで送信された内容をメッセージテーブルのレコードとして作成 */
        $talkrooms_table = new Talkroom();

        $talkrooms_table->name = $request->name;

        if (isset($request->image)) {
            $talkrooms_table->image = $request->image->store('gruopdata', 'public');
        }
        /* データベースにレコードを追加する */

        $talkrooms_table->save();

        $talkrooms_table->user()->attach($request->members);

        return redirect('/GroupList');
    }
    public function quit(Request $request)
    {

        $group_table = Talkroom::find( $request->group_id );

        $group_table->user()->detach($request->user_id);

        return redirect('/GroupList');
    }

}
