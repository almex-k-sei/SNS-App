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
        <p>
            @if($my_id == $message->user_id)
                <div style='text-align: right;'>
            @else
                <div>
            @endif
            <img src="{{$message->user->profile->image}}" width="50px" height="50px">
            {{$message->user->profile->name}}:{{$message->content}}

            </div>
        </p>
    @endforeach

    <form action="" method="POST">
        <input type="text" name="content">
        <input type="hidden" name="user_id" value={{$my_id}}>
        <input type="hidden" name="talkroom_id" value={{$talkroom->id}}>
        <input type="submit" value="送信">
        @csrf
    </form>
</body>
</html>
