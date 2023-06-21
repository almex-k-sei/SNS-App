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
        <!--自分のプロフィール画像-->
        <img src="{{$profiles->filepath}}" alt="">

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
            <img src="!my_filepath!" alt="">
            <table>
                <tr>
                    <td>
                        名前
                    </td>
                    <td>
                        !my_name!
                    </td>
                </tr>
                <tr>
                    <td>
                        生年月日
                    </td>
                    <td>
                        !my_birth!
                    </td>
                </tr>
                <tr>
                    <td>
                        ひとこと
                    </td>
                    <td>
                        !my_description!
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
                @foreach($all_friends as $friend)
                <details>
                    <summary>
                        <div>{{$friend->filepath}}</div>
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