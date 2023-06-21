<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>メッセージ</title>
    <!-- メッセージ一覧から選択・クリックすると飛ぶフレンド・グループとのチャット履歴についてのview--->
</head>
<body>
    <h1>{{$talkroom->name}}</h1>
    @foreach ($messages as $message)
        @if($my_id == $message->user_id)
            </p>{{$message->user->name}}(自分):{{$message->content}}</p>
        @else
        </p>{{$message->user->name}}:{{$message->content}}</p>
        @endif
    @endforeach
</body>
</html>
