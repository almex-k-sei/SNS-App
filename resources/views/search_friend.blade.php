<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
友達追加
<form action="/search_friend" method="post">
    <input type="text" name="friend_email">
    <input type="submit" value="検索">
    @csrf
</form>


<form action="/add_friend" method="post">
    <img src="{{$results->image}}" alt=""> 
    {{$results->name}} 
    @csrf
    <input type="submit" name="add_friend" value="追加">
    <input type="hidden" name="user_id" value="{{$user_id}}">
</form>
</body>
</html>