<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ホーム</title>
    <!-- ログイン後一番最初に飛ぶホーム画面。画面設定3または4のイメージ-->
</head>
<body>
    <header>
        <!--ロゴ画像-->
        <img src="" alt="">
    <!--ログアウト-->
    {{Auth::user()->name}}
    <form action="{{route('logout')}}" method="post">
        <button type="submit">ログアウト</button>
        @csrf
    </form>
    </header>
    <main>
        <!--自分のプロフィール -->
        <div>
            <!--自分のプロフィール画像-->
            <img src="{{$profiles[0]->image}}" alt="">

            <table>
                <tr>
                    <td>
                        名前
                    </td>
                    <td>
                    {{$profiles[0]->name}}
                    </td>
                </tr>
                <tr>
                    <td>
                        生年月日
                    </td>
                    <td>
                    {{$profiles[0]->birth}}
                    </td>
                </tr>
                <tr>
                    <td>
                        ひとこと
                    </td>
                    <td>
                    {{$profiles[0]->description}}
                    </td>
                </tr>
            </table>
        </div>

        <!--友達のプロフィール -->
        <div>
            <!--検索-->
            <form action="" method="GET">
             @csrf
                <input type="text" name="keyword" value="{{$keyword}}">
                <input type="submit" value="検索">
            </form>
            <!-- 友達一覧-->
            <div>
                @foreach($user->followers as $friend)
                <details>
                    <summary>
                        <div>{{$friend->image}}</div>
                        <div>{{$friend->name}}</div>
                        <div>
                            <!-- トーク作成ボタン-->
                            <form action="" method="post">
                                @csrf
                                <input type="submit" src="">
                            </form>
                        </div>
                    </summary>
                {{$friend->birthday}}
                {{$friend->description}}
                </details>
                @endforeach
            </div>
        </div>
    </main>
    <footer>
        <nav>
            <li><a href="home">ホーム</a></li>
            <li><a href="message_list">トーク</a></li>
            <li><a href="group_list">グループ</a></li>
    </footer>
</body>
</html>