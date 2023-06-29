<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Talkroom;
use App\Models\Memo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MessageController extends Controller
{
    public function index(Request $request)
    {
        /* トークルームIDをrequestで受け取る
        !empty($request->old()) && $request->old('content') == NULLはメッセージ何も無しで送信されたとき
        sendのredirectで入ってきた場合は、request->oldという形で入ってくる */
        if (null !== $request->old('talkroom_id')) {
            $talkroom_id = $request->old('talkroom_id');
        } else if (!empty($request->old()) && $request->old('content') == NULL) {
            $talkroom_id = $request->old('talkroom_id');
        } else {
            $talkroom_id = $request->talkroom_id;
        }

        /* URLで直接/Messageを入力されたときは、トークルームリストへ */
        if( $talkroom_id == NULL){
            return redirect('/MessageList');
        }

        /* ログインしているユーザーのIDを取得
        会話するトークルームのIDを取得
        そのトークルームのメッセージを取得 */
        $my_id = Auth::id();
        $talkroom = Talkroom::find($talkroom_id);
        $messages = Message::where('talkroom_id', '=', $talkroom_id)->orderBy('created_at')->get();

        /* viewファイルで日時表示に使うフラグ */
        $previous_ymd = 0;

        /* メモの取得 */
        $memo = Memo::where('user_id', $my_id)
                ->where('talkroom_id', $talkroom_id)
                ->orderBy('created_at')
                ->first();

        /* 受信モードのON・OFF */
        if($request->refresh_flag !== NULL){
            $refresh_flag = $request->refresh_flag;
        }else{
            $refresh_flag = "OFF";
        }

        return view('message', compact('my_id', 'talkroom', 'messages', 'previous_ymd', 'memo', 'refresh_flag', 'talkroom_id'));
    }
    public function send(Request $request)
    {
        /* バリデーション */
        $request->validate(
            [
            'content' => 'required_without:file|max:1024',
            'file' => 'required_without:content'
            ],
            [
                'content.required_without' => 'メッセージを入力またはファイルを選択してください。',
                'file.required_without' => 'メッセージを入力またはファイルを選択してください',
                'content.max' => '文字数が多すぎます'
            ]
        );

        /* formで送信された内容をメッセージテーブルのレコードとして作成 */
        $message_table = new Message();
        $message_table->content = $request->content;
        if (isset($request->file)) {
            $message_table->filename = $request->file->getClientOriginalName();
            $message_table->filepath = $request->file->store('filedata', 'public');
            $message_table->filetype = $request->file->getMimeType();
        }
        $message_table->user_id = $request->user_id;
        $message_table->talkroom_id = $request->talkroom_id;

        /* データベースにレコードを追加する */
        $message_table->save();

        /* 現在会話しているトークルームのIDを保持してリダイレクトで送る */
        $talkroom_id = $request->talkroom_id;

        return redirect('/Message')->withInput(['talkroom_id' => $talkroom_id]);
    }

    public function add_memo(Request $request)
    {
        /* バリデーション */
        $request->validate(
            [
            'memo' => 'max:400',
            ],
            [
                'memo.max' => '400文字以内にしてください'
            ]
        );

        $memo_table = new Memo();
        $memo_table->content = $request->content;
        $memo_table->user_id = $request->user_id;
        $memo_table->talkroom_id = $request->talkroom_id;

        /* データベースにレコードを追加する */
        $memo_table->save();

        /* 現在会話しているトークルームのIDを保持してリダイレクトで送る */
        $talkroom_id = $request->talkroom_id;

        return redirect('/Message')->withInput(['talkroom_id' => $talkroom_id]);
    }

    public function update_memo(Request $request)
    {
        /* バリデーション */
        $request->validate(
            [
            'memo' => 'max:400',
            ],
            [
                'memo.max' => '400文字以内にしてください'
            ]
        );

        $memo = Memo::where('user_id', $request->user_id)
                ->where('talkroom_id', $request->talkroom_id)
                ->first();

        $memo->content = $request->content;

        /* データベースにレコードを追加する */
        $memo->save();

        /* 現在会話しているトークルームのIDを保持してリダイレクトで送る */
        $talkroom_id = $request->talkroom_id;

        return redirect('/Message')->withInput(['talkroom_id' => $talkroom_id]);
    }

}
