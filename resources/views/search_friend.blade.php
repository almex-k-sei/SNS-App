<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    {{-- CSS読み込み --}}
    <link rel="stylesheet" href="css/search_friends.css">
</head>
<body>
    <div class="search_friends_container">
        <h2>友達追加</h2>
        <form action="/search_friend" method="post">
            <input type="text" name="friend_email">
            <input type="submit" value="検索">
            @csrf
        </form>


        <form class="add_friend" action="/add_friend" method="post">
            <img src="{{$results->image}}" alt="">
            {{$results->name}}
            @csrf
            <input type="submit" name="add_friend" value="追加">
            <input type="hidden" name="user_id" value="{{$friend_id}}">
        </form>
    </div>
</body>
</html>
