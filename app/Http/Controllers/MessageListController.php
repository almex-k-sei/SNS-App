<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Talkroom;
use Illuminate\Support\Facades\DB;


class MessageListController extends Controller
{
    /* メッセージの一覧（トークルーム一覧）画面を表示する */
    public function index(Request $request)
    {
        /* ログインしているユーザーが所属しているトークルームの一覧を取得（最後のメッセージ順に並び替え） */
        $user_id = Auth::id();
        $talkrooms = Talkroom::leftJoin('messages', 'talkrooms.id', '=', 'messages.talkroom_id')
                    ->select('talkrooms.*', DB::raw('COALESCE(MAX(messages.created_at), talkrooms.created_at) AS sort_date'))
                    ->groupBy('talkrooms.id')
                    ->orderBy('sort_date', 'desc')
                    ->get();

        /* キーワードを取得 */
        $keyword = $request->input('keyword');

        /* 検索キーワードが入力されている場合、表示するデータを絞り込む */
        if (Str::length($keyword) > 0) {
            $talkrooms = $talkrooms[0]->where('name', 'LIKE', "%$keyword%")->get();
        }

        return view('message_list', compact('talkrooms', 'user_id', 'keyword'));
    }
    public function add_talkroom(Request $request)
    {
        /* friend_idの相手とのトークルームが存在するかチェックし、
        存在している場合は$talkroom_idにIDを保持 */
        $user = User::where('id', $request->user_id)->first();
        $talkroom_id = 0;
        foreach ($user->talkroom as $talkroom){
            if($talkroom->user->contains('id', $request->friend_id) && $talkroom->type !== 'group'){
                $talkroom_id = $talkroom->id;
                break;
            }
        }

        /* friend_idの相手とのトークルームが存在しない場合は、
        新しいトークルームを作成してテーブルに追加 */
        if($talkroom_id == 0){
            /* 新しいトークルームの作成、トークルームの名前は"" */
            /* 名前の表示はviewファイルで""を条件にして相手の名前を出すように分岐 */
            $talkroom_table = new Talkroom();
            $talkroom_table->name = "";
            $talkroom_table->save();

            /* 中間テーブルの更新 */
            $talkroom_table->user()->attach($request->user_id);
            $talkroom_table->user()->attach($request->friend_id);

            /* 会話するトークルームのIDを保持 */
            $talkroom_id = $talkroom_table->id;
        }

        return redirect('/Message')->withInput(['talkroom_id' => $talkroom_id]);
    }
}
