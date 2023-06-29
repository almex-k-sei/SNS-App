<?php

namespace App\Http\Controllers;

use App\Models\Talkroom;
use App\Models\Message;
use App\Models\User;
use App\Models\Memo;
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
        $groupsQuery = $user->talkroom()->where('type', '=', 'group');
        $group_members = [];


        $keyword = $request->input('keyword');
        /* 検索キーワードが入力されている場合、表示するデータを絞り込む */
        if (Str::length($keyword) > 0) {
            $groupsQuery->where('name', 'LIKE', "%$keyword%");
        }
        $groups = $groupsQuery->get();
        // dd($groups);
        return view('group_list', compact('groups','all_friends','group_members'));
    }

    public function add(Request $request)
    {
        /* バリデーション */

        $request->validate(
            [
            'name' => 'required|max:30',
            'image' => 'image',
            'members' => 'required|min:1|max:1000',
            ],
            [
                'name.required' => 'グループ名を入力してください',
                'name.max' => 'グループ名の文字数が多すぎます',
                'image.image' => '画像ファイルを指定してください',
                'members.required' => '最低でも1人は選択してください',
                'members.min' => '最低でも1人は選択してください',
                'members.max' => '人数が多すぎます'
            ]
        );

        /* formで送信された内容をメッセージテーブルのレコードとして作成 */
        $talkrooms_table = new Talkroom();

        $talkrooms_table->name = $request->name;

        if (isset($request->image)) {
            $talkrooms_table->image = $request->image->store('groupdata', 'public');
        }else{
            $talkrooms_table->image = "https://icon-pit.com/wp-content/uploads/2018/10/question_mark_icon_1034.png";
        }
        /* データベースにレコードを追加する */
        $talkrooms_table->type = 'group';

        $talkrooms_table->administrator_id = Auth::id();

        $talkrooms_table->save();

        $talkrooms_table->user()->attach(Auth::id());

        $talkrooms_table->user()->attach($request->members);

        return redirect('/GroupList');
    }
    // グループ退会機能
    public function quit(Request $request)
    {

        $talkrooms_table = Talkroom::find( $request->group_id );

        $talkrooms_table->user()->detach($request->user_id);

        if($talkrooms_table->user() == null){
            $talkrooms_table->delete();
        }

        return redirect('/GroupList');
    }
    // グループ削除機能(管理者)
    public function delete(Request $request)
    {

        $messages_table = Message::where("talkroom_id", "=", $request->group_id )->get();
        $messages_table->each(function ($message) {
            $message->delete();
        });

        $memos_table = Memo::where("talkroom_id", "=", $request->group_id )->get();
        $memos_table->each(function ($memo) {
            $memo->delete();
        });

        $talkrooms_table = Talkroom::find( $request->group_id );
        $talkrooms_table->user()->detach();
        $talkrooms_table->delete();

        return redirect('/GroupList');
    }

    // グループ編集機能(管理者)
    public function edit(Request $request)
    {
        /* バリデーション */

        $request->validate(
            [
            'name' => 'required|max:30',
            'image' => 'image',
            'members' => 'max:1000',
            ],
            [
                'name.required' => 'グループ名を入力してください',
                'name.max' => 'グループ名の文字数が多すぎます',
                'image.image' => '画像ファイルを指定してください',
                'members.max' => '人数が多すぎます'
            ]
        );

        $talkrooms_table = Talkroom::find($request->group_id);

        $talkrooms_table->name = $request->name;

        if (isset($request->image)) {
            $talkrooms_table->image = $request->image->store('groupdata', 'public');
        }

        $talkrooms_table->user()->sync($request->members);

        $talkrooms_table->user()->attach(Auth::id());

        $talkrooms_table->save();

        return redirect('/GroupList');
    }

    //メンバー追加(全員)
    public function add_member(Request $request)
    {
        /* バリデーション */
        $request->validate(
            [
            'members' => 'required|min:1|max:1000',
            ],
            [
                'members.min' => '最低でも1人は選択してください',
                'members.max' => '人数が多すぎます'
            ]
        );

        /* formで送信された内容をメッセージテーブルのレコードとして作成 */
        $talkrooms_table = Talkroom::find($request->group_id);

        $talkrooms_table->user()->attach($request->members);

        return redirect('/GroupList');
    }

}
