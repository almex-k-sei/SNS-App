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
                                @foreach ($all_friends as $friend)
                                    <option value="{{ $friend->id }}"
                                        @if (Auth::id() == $friend->id) selected @endif>
                                        {{ $friend->profile->name }}
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
                        <img src="{{ $group->image }}" width="200px" height="200px">
                        <h2>{{ $group->name }}</h2>
                    </button>
                    <!-- モーダルウィンドウのコンテンツ -->
                    <div class="modal">
                        <div class="modal-content">
                            <!-- コンテンツをここに追加します -->
                            {{-- メンバーを一覧表示 --}}
                            <div id="main_before">
                                <form action="/GroupList/quit" method="POST">
                                    <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                                    <input type="hidden" name="group_id" value="{{ $group->id }}">
                                    <input type="submit" value="退会">
                                    @csrf
                                </form>
                                <h2>メンバー</h2>
                                @foreach ($group->user as $member)
                                    <p>{{ $member->name }}</p>
                                @endforeach
                                {{-- トークへ移動ボタン --}}
                                <form action="/Message" method="POST">
                                    <input type="hidden" name="id" value="{{ $group->id }}">
                                    <input type="submit" value="トークへ移動">
                                    @csrf
                                </form>
                            </div>

                            {{-- グループの作成者のみが表示されるボタン --}}
                            @if (Auth::id() == $group->administrator_id)
                                <div id='edit_after' class="hidden">
                                    <h2>メンバー編集</h2>
                                    <form action="" method="POST">
                                        <select name="" multiple>
                                            @foreach ($group->user as $member)
                                                <option value="{{ $member->id }}"
                                                    @if (Auth::id() == $member->id) selected @endif>
                                                    {{ $member->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <br>
                                        <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                                        <input type="hidden" name="group_id" value="{{ $group->id }}">
                                        <input type="submit" value="変更">
                                        @csrf
                                    </form>
                                </div>
                                {{-- メンバーの編集 --}}
                                <div id='edit_before_button'>
                                    <button onclick="EditMember()">編集</button>
                                </div>

                                {{-- グループの削除 --}}
                                <form action="/GroupList/delete" method="POST">
                                    <input type="hidden" name="group_id" value="{{ $group->id }}">
                                    <input type="submit" value="グループの削除">
                                    @csrf
                                </form>
                            @else
                                <div id='add_after' class="hidden">
                                    <h2>メンバー追加</h2>
                                    <form action="" method="POST">
                                        <select name="" multiple>
                                            @foreach ($all_friends as $friend)
                                                <option value="{{ $friend->id }}"
                                                    @if (Auth::id() == $friend->id) selected @endif>
                                                    {{ $friend->profile->name }}
                                                </option>
                                            @endforeach

                                        </select>
                                        <br>
                                        <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                                        <input type="hidden" name="group_id" value="{{ $group->id }}">
                                        <input type="submit" value="追加">
                                        @csrf
                                    </form>
                                </div>
                                {{-- メンバーを追加ボタン --}}
                                <div id='add_before_button'>
                                    <button onclick="AddMember()">メンバーを追加</button>
                                </div>
                            @endif
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
            var divA = document.getElementById("main_before");
            var divB = document.getElementById("add_before_button");
            var divC = document.getElementById("add_after");
            var divD = document.getElementById("edit_before_button");
            var divE = document.getElementById("edit_after");
            closeBtns[i].onclick = function() {
                var modal = this.parentNode.parentNode;
                modal.style.display = "none"; // 対応するモーダルを非表示にする
                divA.style.display = "block";
                divB.style.display = "block";
                divC.style.display = "none";
                divD.style.display = "block";
                divE.style.display = "none";
            };
        }

        // モーダルウィンドウの外側がクリックされた時の処理
        window.onclick = function(event) {
            var divA = document.getElementById("main_before");
            var divB = document.getElementById("add_before_button");
            var divC = document.getElementById("add_after");
            var divD = document.getElementById("edit_before_button");
            var divE = document.getElementById("edit_after");
            for (var i = 0; i < modals.length; i++) {
                if (event.target == modals[i]) {
                    modals[i].style.display = "none"; // 対応するモーダルを非表示にする
                    divA.style.display = "block";
                    divB.style.display = "block";
                    divC.style.display = "none";
                    divD.style.display = "block";
                    divE.style.display = "none";
                }
            }
        };

        function AddMember() {
            var divA = document.getElementById("main_before");
            var divB = document.getElementById("add_before_button");
            var divC = document.getElementById("add_after");

            divA.style.display = "none";
            divB.style.display = "none";
            divC.style.display = "block";
        }

        function EditMember() {
            var divA = document.getElementById("main_before");
            var divB = document.getElementById("edit_before_button");
            var divC = document.getElementById("edit_after");

            divA.style.display = "none";
            divB.style.display = "none";
            divC.style.display = "block";
        }
    </script>
    <style>
        .hidden {
            display: none;
        }
