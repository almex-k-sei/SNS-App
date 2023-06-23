<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Talkroom;
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
        if (null !== $request->old('id')) {
            $id = $request->old('id');
        } else if (!empty($request->old()) && $request->old('content') == NULL) {
            $id = $request->old('talkroom_id');
        } else {
            $id = $request->id;
        }

        /* ログインしているユーザーのIDを取得
        会話するトークルームのIDを取得
        そのトークルームのメッセージを取得 */
        $my_id = Auth::id();
        $talkroom = Talkroom::find($id);
        $messages = Message::where('talkroom_id', '=', $id)->orderBy('created_at')->get();

        return view('message', compact('my_id', 'talkroom', 'messages'));
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

        return redirect('/Message')->withInput(['id' => $talkroom_id]);
    }
}
