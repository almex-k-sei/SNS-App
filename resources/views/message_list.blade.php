@include('header')

    <div class="message_list_container">

        <div class="list_title_container">
            <h1 class="list_title">メッセージ一覧</h1>
            {{-- 検索キーワードの送信 --}}
            <form action="/MessageList" method="GET">
                <label>
                    検索キーワード
                    <input type="text" name="keyword" value="{{ $keyword }}">
                </label>
                <input type="submit" value="検索">
            </form>
        </div>

        <div class="list_contents_container">
            <div>
            {{-- トークルーム名とそのトークルームの最後のメッセージを表示 --}}
            @foreach ($talkrooms as $talkroom)
                <form action="/Message" method="POST">
                    <button>
                        <h2>{{$talkroom->name}}</h2>
                        <p>最後のメッセージ：
                            @if(isset($talkroom->message->last()->content))
                                {{$talkroom->message->last()->content}}
                            @endif
                        </p>
                        <input type="hidden" name="id" value={{$talkroom->id}}>
                    </button>
                    @csrf
                </form>
            @endforeach
            </div>
        </div>

    </div>

@include('footer')
