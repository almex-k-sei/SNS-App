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
        </div>

        <div class="list_contents_container">
            <div>
            {{-- トークルーム名とそのトークルームの最後のメッセージを表示 --}}
            @foreach ($groups as $group)
                <form action="/Group" method="POST">
                    <button>
                        <h2>{{$group->name}}</h2>
                        <p>最後のメッセージ：{{$group->message->last()->content}}</p>
                        <input type="hidden" name="id" value={{$group->id}}>
                    </button>
                    @csrf
                </form>
            @endforeach
            </div>
        </div>

    </div>

@include('footer')
