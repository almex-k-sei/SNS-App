@include('header')
<div class="message_list_container">

    <div class="list_title_container">
        <h1 class="list_title">グループ一覧</h1>
        {{-- 検索キーワードの送信 --}}
        <form action="/GroupList" method="GET">
            <label>
                検索キーワード
                <input type="text" name="keyword">
            </label>
            <input type="submit" value="検索">
        </form>
        <!-- モーダルウィンドウのトリガーボタン -->
        <button class="modalBtn addBtn">グループを追加</button>

        <!-- モーダルウィンドウのコンテンツ -->
        <div class="modal">
            <div class="modal-content">
                <form action="/GroupList/add" method="POST" enctype="multipart/form-data">
                    <!-- モーダルウィンドウの中身 -->
                    <p><label>
                            グループ名
                            <input type="text" name="name">
                        </label></p>
                    <p><label>
                            画像
                            <input type="file" name="image">
                        </label></p>
                    <p><label>
                            メンバー
                            <select name="members[]" multiple>
                                @foreach ($all_users as $user)
                                    <option value="{{ $user->id }}"
                                        @if(Auth::id() == $user->id )
                                            selected
                                        @endif
                                        >
                                        {{$user->profile->name}}
                                    </option>
                                @endforeach
                            </select>
                        </label></p>
                    <p><input type="submit" value="追加"></p>
                    @csrf
                </form>
                <span class="close">&times;</span>
            </div>
        </div>

        {{-- バリデーションエラー --}}
        <p>{{ $errors->first('name') }}</p>
        <p>{{ $errors->first('image') }}</p>
        <p>{{ $errors->first('members') }}</p>



        <div class="list_contents_container">
            <div>
                {{-- グループ一覧の表示 --}}
                @foreach ($groups as $group)
                    <button class="modalBtn">
                        <img src="{{$group->image}}" width="200px" height="200px">
                        <h2>{{ $group->name }}</h2>
                    </button>
                    <!-- モーダルウィンドウのコンテンツ -->
                    <div class="modal">
                        <div class="modal-content">
                            <!-- コンテンツをここに追加します -->
                            <h2>メンバー</h2>
                            @foreach ($group->user as $user)
                                <p>{{ $user->name }}</p>
                            @endforeach
                            <form action="/Message" method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="id" value="{{$group->id}}">
                                <input type="submit" value="トークへ移動">
                                @csrf
                            </form>
                            <span class="close">&times;</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    </div>

    @include('footer')


    <script>
        'use strict';
        // モーダルウィンドウのトリガーボタンを取得
        var modalBtns = document.getElementsByClassName("modalBtn");

        // モーダルウィンドウの要素を取得
        var modals = document.getElementsByClassName("modal");

        // 閉じるボタンを取得
        var closeBtns = document.getElementsByClassName("close");

        // トリガーボタンがクリックされた時の処理
        for (var i = 0; i < modalBtns.length; i++) {
            modalBtns[i].onclick = function() {
                var modal = this.nextElementSibling;
                modal.style.display = "block"; // 対応するモーダルを表示する
            };
        }

        // 閉じるボタンがクリックされた時の処理
        for (var i = 0; i < closeBtns.length; i++) {
            closeBtns[i].onclick = function() {
                var modal = this.parentNode.parentNode;
                modal.style.display = "none"; // 対応するモーダルを非表示にする
            };
        }

        // モーダルウィンドウの外側がクリックされた時の処理
        window.onclick = function(event) {
            for (var i = 0; i < modals.length; i++) {
                if (event.target == modals[i]) {
                    modals[i].style.display = "none"; // 対応するモーダルを非表示にする
                }
            }
        };
    </script>