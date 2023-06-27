
<!--    ログイン後一番最初に飛ぶホーム画面。画面設定3または4のイメージ-->
    @include('header')
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
                            <div class="description_container">
                                <input type="text"  id="description"name="description"  placeholder="{{$profiles[0]->description}}">
                            </div>
                        </td>
                    </tr>
                </table>
                <details>
                    <summary>プロフィール画像を編集</summary>
                    URL<input type="url"  id="url" name="url">
                </details>
                <input type="submit" id="submit"value="編集">
            </form>

        </div>

        <!--友達のプロフィール -->
        <div class="friends_profile">
            <!--検索-->
            <div class="search_friends">
                <form action="" method="GET">
                 @csrf
                    <input type="text" name="keyword" value="{{$keyword}}">
                    <input type="submit" value="検索">
                </form>
            </div>
            <label class="open" for="pop-up">友達追加</label>
                <input type="checkbox" id="pop-up">
                <div class="overlay">
	                <div class="window">
		                <label class="close" for="pop-up">×</label>
		                    <div class="add_friend">
                                <form action="" method="get">
                                    <input type="text" name="friend_email">
                                    <input type="submit" value="検索">
                                </form>
                            </div>
	                </div>
                </div>
            <!-- 友達一覧-->
            <div class="friends_list">
                @foreach($friends as $friend)
                <details>
                    <summary>
                        <div><img src={{$friend->profile->image}} id="image"></div>
                        <div id="name">{{$friend->profile->name}}</div>
                        <div id="talk">
                            <!-- トーク作成ボタン-->
                            <form action="/MessageList/add" method="post">
                                <button class="create_talk" type="submit">
                                    <i class="far fa-comments"></i>
                                </button>
                                <input type="hidden" name="user_id" value="{{$user_id}}">
                                <input type="hidden" name="friend_id" value="{{$friend->id}}">
                                @csrf
                            </form>
                        </div>
                    </summary>
                    <div class="friends_list_detail">
                        <p>{{$friend->profile->birth}}</p>
                        <p>{{$friend->profile->description}}</p>
                    </div>
                </details>
                @endforeach
            </div>
        </div>
    </main>
    @include('footer')
