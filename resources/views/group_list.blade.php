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
        <button class="modalBtn addBtn">追加</button>

        <!-- モーダルウィンドウのコンテンツ -->
        <div class="modal">
            <div class="modal-content">
                <!-- コンテンツをここに追加します -->
                <span class="close">&times;</span>
            </div>
        </div>



    <div class="list_contents_container">
        <div>
            {{-- トークルーム名とそのトークルームの最後のメッセージを表示 --}}
            @foreach ($groups as $group)
                <button class="modalBtn">
                    <img src="{{ $group->image }}" height="100" width="100">
                    <h2>{{ $group->name }}</h2>
                </button>
                <!-- モーダルウィンドウのコンテンツ -->
                <div class="modal">
                    <div class="modal-content">
                        <!-- コンテンツをここに追加します -->
                        @foreach ($group->user as $user)
                            <p>{{$user->name}}</p>
                        @endforeach
                        <span class="close">&times;</span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

</div>

@include('footer')

<style>
.addBtn {
    width: 50px;
}

/* モーダルウィンドウ */
.modal {
    display: none; /* 最初は非表示にする */
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.5); /* 背景を半透明にする */
}

/* モーダルウィンドウのコンテンツ */
.modal-content {
    position: relative; /* 追加 */
    background-color: #fefefe;
    margin: 15% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
}

/* 閉じるボタン */
.close {
    position: absolute; /* 追加 */
    top: 0; /* 追加 */
    right: 0; /* 追加 */
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
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
