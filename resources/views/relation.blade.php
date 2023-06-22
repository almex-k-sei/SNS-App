<?php
use App\Models\Teacher;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>リレーション</title>
</head>
<body>
    <h1>先生一覧</h1>
    @foreach ($all_teachers as $teacher)
        <table border="1">
            <tr>
                <td>ID</td>
                <td>{{$teacher->id}}</td>
            </tr>
            <tr>
                <td>名前</td>
                <td>{{$teacher->name}}</td>
            </tr>
            <tr>
                <td>担任クラス</td>
                <td>{{$teacher->homeroom->name}}</td>
            </tr>
            <tr>
                <td>
                    <form action="edit_teacher/{{$teacher->id}}" method="POST">
                        <input type="submit" value="編集">
                        <input type="hidden" name="name" value="{{$teacher->name}}">
                        <input type="hidden" name="name" value="{{$teacher->name}}">
                        @csrf
                    </form>
                </td>
                <td>
                    <form action="delete_teacher/{{$teacher->id}}" method="POST">
                        <input type="submit" value="削除">
                        @csrf
                    </form>
                </td>
            </tr>
        </table>
        <br>
    @endforeach
    <a href="school">戻る</a>
</body>
</html>
