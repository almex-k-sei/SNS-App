<!--    ログイン後一番最初に飛ぶホーム画面。画面設定3または4のイメージ-->
@include('header')
<main>
    <!--自分のプロフィール -->
    <div class="my_profile">
        <!--自分のプロフィール画像-->
        <img src="{{ $profiles[0]->image }}" alt="" id="image">
        <form class="my_editable_profile" action="" method="post" enctype="multipart/form-data">
            @csrf
            <table>
                <tr>
                    <td>
                        <input type="text" id="name" name="name" placeholder="{{ $profiles[0]->name }}">
                        {{-- <textarea name="name" id="name" cols="30" rows="2">{{ $profiles[0]->name }}</textarea> --}}
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="description_container">
                            <input type="text" id="description" name="description"
                                placeholder="{{ $profiles[0]->description }}">
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="text" id="birthday"name="birthday" placeholder="{{ $profiles[0]->birth }}">
                    </td>
                </tr>
            </table>
            <details>
                <summary>プロフィール画像を編集する</summary>
                <label class= "file" for="submit">
                <input type="file" id="url" name="url" >
                <!-- onchange="$('#fake_text_box').val($(this).val())" -->
                <!-- <input type="text" id="file_upload" value="ファイル選択" onClick="$('#file').click();"> -->
                </label>
                <!-- <input type="text" id="fake_text_box" value="" size="35" readonly onClick="$('#file').click();"> -->
            </details>
            <input type="submit" id="submit"value="編集">
        </form>
        <p>{{ $errors->first('url') }}</p>


        <!--友達に追加されたときの通知機能および追加ボタン-->

            @foreach ($user->followers as $follower)
                @unless ($user->follows->contains('id', $follower->id))
                <div class="added_as_friend">
                    <div class="notification">
                        <p>{{$follower->profile->name }}に友達追加されました</p>
                        <form action="/accept_request" method="post">
                            <input type="hidden" name="id" value="{{$follower->id}}">
                            <input type="submit" name="submit" value="追加">
                            @csrf
                        </form>
                    </div>
                </div>
                @endunless
            @endforeach

    </div>






    <!--友達のプロフィール -->
    <div class="friends_profile">
        <div class="friends_header">
            <!--検索-->
            <div class="search_friends">
                <form action="" method="GET">
                    @csrf
                    <input type="text" name="keyword" value="{{ $keyword }}">
                    <input type="submit" value="検索">
                </form>
            </div>
            <div class="add_friends">
                {{-- <label class="open" for="pop-up"><i class="fas fa-user-plus"></i></label>
                    <input type="checkbox" id="pop-up"> --}}
                {{-- <div class="overlay">
                        <div class="window">
                            <label class="close" for="pop-up">×</label>
                            <div class="add_friend">
                                <form action="" method="get">
                                    <input type="text" name="friend_email">
                                    <input type="submit" value="検索">
                                </form>
                            </div>
                        </div>
                    </div> --}}
                <form action="search_friend">
                    <input type="submit" value="友達追加">
                    {{-- <i class="fas fa-user-plus"></i> --}}
                </form>
            </div>
            <!--friends_header-->
            <!--友達を追加するボタン　-->


        </div>
        <!-- 友達一覧-->
        <div class="friends_list">
            @foreach ($friends as $friend)
                <details>
                    <summary>
                        <div><img src={{ $friend->profile->image }} id="image"></div>
                        <div id="name">{{ $friend->profile->name }}</div>
                        <div id="talk">
                            <!-- トーク作成ボタン-->
                            <form action="/MessageList/add" method="post">
                                <button class="create_talk" type="submit">
                                    <i class="far fa-comments"></i>
                                </button>
                                <input type="hidden" name="user_id" value="{{ $user_id }}">
                                <input type="hidden" name="friend_id" value="{{ $friend->id }}">
                                @csrf
                            </form>
                        </div>
                    </summary>
                    <div class="friends_list_detail">
                        <p>{{ $friend->profile->birth }}</p>
                        <p>{{ $friend->profile->description }}</p>
                    </div>
                </details>
            @endforeach
        </div>
</main>
@include('footer')
{{-- <style>
    img{
        width:100px;
        height:100px;
    }
</style> --}}
