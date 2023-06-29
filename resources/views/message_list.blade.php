@include('header')

    <div class="message_list_container">

        <div class="list_title_container">
            <h1 class="list_title">トークルーム一覧</h1>
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
                            @if ($talkroom->name == "")
                                <h2>
                                    @foreach ($talkroom->user as $user)
                                        @if ($user->id != $user_id)
                                            {{$user->name}}　
                                        @endif
                                    @endforeach
                                </h2>
                            @else
                                <h2>{{$talkroom->name}}</h2>
                            @endif
                            @if ($talkroom->message->last() !== NULL)
                                <?php
                                    /* メッセージの送信日時を取得 */
                                    $time = $talkroom->message->last()->created_at;
                                    $timestamp = strtotime($time);
                                    $mdhm = date("m/d H:i", $timestamp);
                                    $hm = date("H:i", $timestamp);
                                ?>
                                @if($talkroom->message->last()->content == NULL)
                                    <p>{{$mdhm}}<br>
                                        コンテンツが送信されました</p>
                                @else
                                    <p>{{$mdhm}}<br>
                                        {{$talkroom->message->last()->content}}</p>
                                @endif
                            @else
                                <p>New Talkroom!</p>
                            @endif
                            <input type="hidden" name="talkroom_id" value={{$talkroom->id}}>
                        </button>
                        @csrf
                    </form>
                @endforeach
                </div>
            </div>

        </div>

@include('footer')
