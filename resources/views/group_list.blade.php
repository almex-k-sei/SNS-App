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
                            @foreach ($all_friends as $friend)
                                <p>
                                    <label for="friend_{{ $friend->id }}">
                                        <input type="checkbox" name="members[]" value="{{ $friend->id }}">
                                        {{ $friend->profile->name }}
                                    </label>
                                </p>
                            @endforeach
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
                            {{-- メンバーを一覧表示（最初に表示されます） --}}
                            <div class="main_before">
                                <form action="/GroupList/quit" method="POST">
                                    <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                                    <input type="hidden" name="group_id" value="{{ $group->id }}">
                                    <input type="submit" value="退会">
                                    @csrf
                                </form>
                                <h2>メンバー</h2>
                                @foreach ($group->user as $member)
                                    <p>{{ $member->profile->name }}</p>
                                @endforeach
                                {{-- トークへ移動ボタン --}}
                                <form action="/Message" method="POST">
                                    <input type="hidden" name="id" value="{{ $group->id }}">
                                    <input type="submit" value="トークへ移動">
                                    @csrf
                                </form>
                            </div>

                            {{-- メンバー編集ボタンを押すと表示される内容 --}}
                            <div class='edit_after hidden'>
                                <h2>グループの編集</h2>
                                <form action="" method="POST" enctype="multipart/form-data">
                                    <!-- モーダルウィンドウの中身 -->
                                    <p><label>
                                            グループ名
                                            <input type="text" name="name" value="{{ $group->name }}">
                                        </label></p>
                                    <p><label>
                                            現在の画像
                                            <p><img src="{{ $group->image }}" width="100px" height="100px"></p>
                                            <p>画像<input type="file" name="image"></p>
                                        </label></p>
                                    <p><label>
                                            メンバー
                                            @foreach ($all_friends as $friend)
                                                <p>
                                                    <label for="friend_{{ $friend->id }}">
                                                        <input type="checkbox" name="members[]"
                                                            value="{{ $friend->id }}"
                                                            @foreach ($group->user as $member)
                                                            @if ($member->id == $friend->id)
                                                            checked
                                                            @endif @endforeach>
                                                        {{ $friend->profile->name }}
                                                    </label>
                                                </p>
                                            @endforeach
                                        </label></p>
                                    <p><input type="submit" value="更新"></p>
                                    @csrf
                                </form>
                            </div>

                            {{-- グループ削除ボタンを押すと表示される内容 --}}
                            <div class='delete_after hidden'>
                                <h2>本当に削除しますか？</h2>
                                <form action="/GroupList/delete" method="POST">
                                    <input type="hidden" name="group_id" value="{{ $group->id }}">
                                    <input type="submit" value="はい">
                                    <input type="button" onclick="NoDelete()" value="いいえ">
                                    @csrf
                                </form>
                            </div>

                            {{-- メンバー追加ボタンを押すと表示される内容 --}}
                            <div class='add_after hidden'>
                                <h2>メンバー追加</h2>
                                <form action="" method="POST">
                                    <p>
                                        @foreach ($all_friends as $friend)
                                        @php
                                            $isMember = false;
                                        @endphp
                                        @foreach ($group->user as $member)
                                            @if($member->id == $friend->id)
                                                @php
                                                    $isMember = true;
                                                @endphp
                                                @break
                                            @endif
                                        @endforeach

                                        @if(!$isMember)
                                            <p>
                                                <label for="friend_{{ $friend->id }}">
                                                    <input type="checkbox" name="members[]" value="{{ $friend->id }}">
                                                    {{ $friend->profile->name }}
                                                </label>
                                            </p>
                                        @endif
                                    @endforeach
                                    </p>
                                    <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                                    <input type="hidden" name="group_id" value="{{ $group->id }}">
                                    <p><input type="submit" value="追加"></p>
                                    @csrf
                                </form>
                            </div>


                            {{-- グループの作成者かそうでないかを判断 --}}
                            @if (Auth::id() == $group->administrator_id)
                                {{-- メンバーの編集ボタン --}}
                                <div class='edit_before_button'>
                                    <button onclick="EditMember()">グループの編集</button>
                                </div>

                                {{-- グループの削除ボタン --}}
                                <div class='delete_before_button'>
                                    <button onclick="DeleteMember()">グループの削除</button>
                                </div>
                            @else
                                {{-- メンバーを追加ボタン --}}
                                <div class='add_before_button'>
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

    <style>
        .hidden {
            display: none;
        }

        .selectbox-wrapper {
            position: relative;
            width: 200px;
            margin: 0 auto;
            /* 中央に配置するための設定 */
        }

        .selectbox-wrapper select[multiple] {
            width: 100%;
            height: 200px;
            font-size: 16px;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color: #f7f7f7;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            overflow-y: auto;
        }

        .selectbox-wrapper select[multiple] option {
            padding: 5px;
        }

        .selectbox-wrapper select[multiple] option:checked {
            background-color: #337ab7;
            color: #fff;
        }
    </style>

    <script>
        'use strict';
        // モーダルウィンドウのトリガーボタンを取得
        var modalBtns = document.getElementsByClassName("modalBtn");

        // モーダルウィンドウの要素を取得
        var modals = document.getElementsByClassName("modal");

        // 閉じるボタンを取得
        var closeBtns = document.getElementsByClassName("close");

        var divA = document.getElementsByClassName("main_before");
        var divB = document.getElementsByClassName("add_before_button");
        var divC = document.getElementsByClassName("add_after");
        var divD = document.getElementsByClassName("edit_before_button");
        var divE = document.getElementsByClassName("edit_after");
        var divF = document.getElementsByClassName("delete_before_button");
        var divG = document.getElementsByClassName("delete_after");

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
                for (var i = 0; i < divA.length; i++) {
                    divA[i].style.display = "block";
                }

                for (var j = 0; j < divB.length; j++) {
                    divB[j].style.display = "block";
                }

                for (var k = 0; k < divC.length; k++) {
                    divC[k].style.display = "none";
                }
                for (var j = 0; j < divD.length; j++) {
                    divD[j].style.display = "block";
                }

                for (var k = 0; k < divE.length; k++) {
                    divE[k].style.display = "none";
                }
                for (var j = 0; j < divD.length; j++) {
                    divF[j].style.display = "block";
                }

                for (var k = 0; k < divE.length; k++) {
                    divG[k].style.display = "none";
                }
            };
        }

        // モーダルウィンドウの外側がクリックされた時の処理
        window.onclick = function(event) {
            for (var i = 0; i < modals.length; i++) {
                if (event.target == modals[i]) {
                    modals[i].style.display = "none"; // 対応するモーダルを非表示にする
                    for (var i = 0; i < divA.length; i++) {
                        divA[i].style.display = "block";
                    }

                    for (var j = 0; j < divB.length; j++) {
                        divB[j].style.display = "block";
                    }

                    for (var k = 0; k < divC.length; k++) {
                        divC[k].style.display = "none";
                    }
                    for (var j = 0; j < divD.length; j++) {
                        divD[j].style.display = "block";
                    }

                    for (var k = 0; k < divE.length; k++) {
                        divE[k].style.display = "none";
                    }
                    for (var j = 0; j < divD.length; j++) {
                        divF[j].style.display = "block";
                    }

                    for (var k = 0; k < divE.length; k++) {
                        divG[k].style.display = "none";
                    }
                }
            }
        };

        function AddMember() {
            var divA = document.getElementsByClassName("main_before");
            var divB = document.getElementsByClassName("add_before_button");
            var divC = document.getElementsByClassName("add_after");

            for (var i = 0; i < divA.length; i++) {
                divA[i].style.display = "none";
            }

            for (var j = 0; j < divB.length; j++) {
                divB[j].style.display = "none";
            }

            for (var k = 0; k < divC.length; k++) {
                divC[k].style.display = "block";
            }
        }


        function EditMember() {
            var divA = document.getElementsByClassName("main_before");
            var divB = document.getElementsByClassName("edit_before_button");
            var divC = document.getElementsByClassName("edit_after");
            var divE = document.getElementsByClassName("delete_before_button");
            for (var i = 0; i < divA.length; i++) {
                divA[i].style.display = "none";
            }

            for (var j = 0; j < divB.length; j++) {
                divB[j].style.display = "none";
            }

            for (var k = 0; k < divC.length; k++) {
                divC[k].style.display = "block";
            }
            for (var k = 0; k < divE.length; k++) {
                divE[k].style.display = "none";
            }
        }

        function DeleteMember() {
            var divA = document.getElementsByClassName("main_before");
            var divB = document.getElementsByClassName("delete_before_button");
            var divC = document.getElementsByClassName("delete_after");
            var divE = document.getElementsByClassName("edit_before_button");

            for (var i = 0; i < divA.length; i++) {
                divA[i].style.display = "none";
            }

            for (var j = 0; j < divB.length; j++) {
                divB[j].style.display = "none";
            }

            for (var k = 0; k < divC.length; k++) {
                divC[k].style.display = "block";
            }
            for (var k = 0; k < divE.length; k++) {
                divE[k].style.display = "none";
            }
        }

        function NoDelete() {
            var divA = document.getElementsByClassName("main_before");
            var divB = document.getElementsByClassName("delete_before_button");
            var divC = document.getElementsByClassName("delete_after");

            for (var i = 0; i < divA.length; i++) {
                divA[i].style.display = "block";
            }

            for (var j = 0; j < divB.length; j++) {
                divB[j].style.display = "block";
            }

            for (var k = 0; k < divC.length; k++) {
                divC[k].style.display = "none";
            }
        }
    </script>
