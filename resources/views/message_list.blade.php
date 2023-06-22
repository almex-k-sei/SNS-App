<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>メッセージリスト</title>
    <!--ホーム画面のフッターナビ「メッセージ」から飛ぶと閲覧できるメッセージの一覧- -->
</head>
<body>
    <h1>メッセージ一覧</h1>
    <div>
        {{-- 検索キーワードの送信 --}}
        <form action="/MessageList" method="GET">
            <label>
                検索キーワード
                <input type="text" name="keyword" value="{{ $keyword }}">
            </label>
            <input type="submit" value="検索">
        </form>
    </div>
    {{-- トークルーム名とそのトークルームの最後のメッセージを表示 --}}
    @foreach ($talkrooms as $talkroom)
        <form action="">
            <button>
                <h2>{{$talkroom->name}}</h2>
                <p>最後のメッセージ：{{$talkroom->message->last()->content}}</p>
            </button>
        </form>
    @endforeach
</body>
</html>
