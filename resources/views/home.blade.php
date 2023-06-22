
<!--    ログイン後一番最初に飛ぶホーム画面。画面設定3または4のイメージ-->
    @include('header')
    <link rel="stylesheet" href="/css/home_main.css">
    <main>
        <!--自分のプロフィール -->
        <div class="my_profile">
            <!--自分のプロフィール画像-->
            <img src="{{$profiles[0]->image}}" alt="" id="image">
            <form class = "my_editable_profile" action="" method="post">
                @csrf
                <table>
                    <tr>
                        <td>
                            <input type="text" id="name" name="name" placeholder="{{$profiles[0]->name}}">
                        </td>
                    </tr>
                    <tr>
                        <td >
                        <input type="text" id="birthday"name="birthday" placeholder="{{$profiles[0]->birth}}">
                        </td>
                    </tr>
                    <tr>
                        <td>
                        <input type="text"  id="description"name="description"  placeholder="{{$profiles[0]->description}}">
                        </td>
                    </tr>
                </table>
                <details>
                    <summary>プロフィール画像を編集</summary>
                    URL<input type="url" name="url">
                </details>
                <input type="submit" class="submit"value="編集">
            </form>
        
        </div>

        <!--友達のプロフィール -->
        <div class="friends_profile">
            <!--検索-->
            <form action="" method="GET">
             @csrf
                <input type="text" name="keyword" value="{{$keyword}}">
                <input type="submit" value="検索">
            </form>
            <!-- 友達一覧-->
            <div>
                @foreach($friends as $friend)
                <details>
                    <summary>
                        <div><img src={{$friend->profile->image}} id="image"></div>
                        <div id="name">{{$friend->name}}</div>
                        <div id="talk">
                            <!-- トーク作成ボタン-->
                            <form action="" method="post">
                                @csrf
                                <button type="submit">
                                <i class="fas fa-plus"></i>
                                </button> 
                            </form>
                        </div>
                    </summary>
                生年月日:{{$friend->profile->birth}}
                ひとこと:{{$friend->profile->description}}
                </details>
                @endforeach
            </div>
        </div>
    </main>
    @include('footer')
