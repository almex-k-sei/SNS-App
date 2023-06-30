@include('header')

@if ($refresh_flag == 'ON')

    <head>
        <script>
            setTimeout(function() {
                // フォームを生成してPOSTリクエストを送信
                var form = document.createElement('form');
                form.method = 'POST';
                form.action = '';

                // CSRFトークンをhiddenフィールドとして追加
                var csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = '{{ csrf_token() }}'; // CSRFトークンを指定

                // トークルームIDをhiddenフィールドとして追加
                var talkroomId = document.createElement('input');
                talkroomId.type = 'hidden';
                talkroomId.name = 'talkroom_id';
                talkroomId.value = '{{ $talkroom->id }}'; // トークルームIDを指定

                // リフレッシュflagをhiddenフィールドとして追加
                var refreshFlag = document.createElement('input');
                refreshFlag.type = 'hidden';
                refreshFlag.name = 'refresh_flag';
                refreshFlag.value = '{{ $refresh_flag }}'; // リフレッシュflagを指定

                // フォームにhiddenフィールドを追加して送信
                form.appendChild(csrfToken);
                form.appendChild(talkroomId);
                form.appendChild(refreshFlag);
                document.body.appendChild(form);
                form.submit();
            }, 2000); // 3秒後にリダイレクト
        </script>
    </head>
@endif

<h1 class="talkroom_title">
    <div class="back">
        <a href="/MessageList"><i class="fas fa-backward"></i></a>
    </div>
    @if ($talkroom->name == '')
        @foreach ($talkroom->user as $user)
            @if ($user->id != $my_id)
                <div id="talkroom_name"> <i class="fas fa-user"></i>{{ $user->profile->name }}</div>
            @endif
        @endforeach
    @else
        <div id="talkroom_name"> <i class="fas fa-users"></i> {{ $talkroom->name }}</div>
    @endif
    <div class="memo">
        <details>
            <summary><i class="far fa-sticky-note"></i></summary>
            @if ($memo == null)
                <form action="Message/add_memo" method="POST">
                    <textarea name="content" cols="30" rows="10"></textarea>
                    <input type="submit" id="memo_submit"value="メモを保存">
                    <input type="hidden" name="talkroom_id" value={{ $talkroom->id }}>
                    <input type="hidden" name="user_id" value={{ $my_id }}>
                    @csrf
                </form>
            @else
                <form action="Message/update_memo" method="POST">
                    <textarea name="content" cols="30" rows="10">{{ $memo->content }}</textarea>
                    <input type="submit"id="memo_submit" value="メモを保存">
                    <input type="hidden" name="talkroom_id" value={{ $talkroom->id }}>
                    <input type="hidden" name="user_id" value={{ $my_id }}>
                    @csrf
                </form>
            @endif

            {{-- エラーメッセージ --}}
            {{ $errors->first('memo') }}
        </details>
    </div>
    <div class="clear"></div>
</h1>

<div class="container">


    @foreach ($messages as $message)
        <p class="datetime">
            <?php
            /* メッセージの送信日時を取得 */
            $time = $message->created_at;
            $timestamp = strtotime($time);
            $ymd = date('Y/m/d', $timestamp);
            $hm = date('H:i', $timestamp);
            ?>
            @if ($previous_ymd == 0)
                {{ $ymd }}
                <?php $previous_ymd = $ymd; ?>
            @elseif ($previous_ymd != $ymd)
                {{ $ymd }}
                <?php $previous_ymd = $ymd; ?>
            @endif
        </p>
        <div class="message_container">
            @if ($my_id == $message->user_id)
                <div class="text_right_container text_container">
                    <div class="time_bottom right">
                        <p>
                            {{-- メッセージが格納されているか判別 --}}
                            @if (isset($message->content))
                                {{ $message->content }}
                                <br>
                            @endif
                            {{-- ファイルデータが格納されているか判別 --}}
                            @if (isset($message->filepath))
                                {{-- ファイルの形式を判別する　--}}
                                @if (explode('/', $message->filetype)[0] == 'image')
                                    <img src="{{ $message->filepath }}" width="200px" height="200px">
                                @elseif (explode('/', $message->filetype)[0] == 'audio')
                                    <audio controls src="{{ $message->filepath }}"
                                        type="{{ $message->filetype }}"></audio>
                                @elseif (explode('/', $message->filetype)[0] == 'video')
                                    <video src="{{ $message->filepath }}" type="{{ $message->filetype }}"
                                        width="200px" height="200px" autoplay muted loop></video>
                                @endif
                                <br>
                                <a href="{{ $message->filepath }}" download="{{ $message->filename }}"><i
                                        class="fas fa-file-download"></i></a>
                            @endif
                        </p>
                        {{-- 送信時間 --}}
                        {{ $hm }}
                    </div>
                    <img src="{{ $message->user->profile->image }}" width="50px" height="50px">
                @else
                    <div class="text_left_container text_container">
                        {{ $message->user->profile->name }}
                        <img src="{{ $message->user->profile->image }}" width="50px" height="50px">
                        <div class="time_bottom left">
                            <p>{{-- メッセージが格納されているか判別 --}}
                                @if (isset($message->content))
                                    {{ $message->content }}
                                    <br>
                                @endif
                                {{-- ファイルデータが格納されているか判別 --}}
                                @if (isset($message->filepath))
                                    {{-- ファイルの形式を判別する　--}}
                                    @if (explode('/', $message->filetype)[0] == 'image')
                                        <img src="{{ $message->filepath }}" width="200px" height="200px">
                                    @elseif (explode('/', $message->filetype)[0] == 'audio')
                                        <audio controls src="{{ $message->filepath }}"
                                            type="{{ $message->filetype }}"></audio>
                                    @elseif (explode('/', $message->filetype)[0] == 'video')
                                        <video src="{{ $message->filepath }}" type="{{ $message->filetype }}"
                                            width="200px" height="200px" autoplay muted loop></video>
                                    @endif
                                    <br>
                                    <a href="{{ $message->filepath }}" download="{{ $message->filename }}"><i
                                            class="fas fa-file-download"></i></a>
                                @endif
                            </p>
                            {{-- 送信時間 --}}
                            {{ $hm }}
                        </div>
            @endif
        </div>
</div>
@endforeach

@if ($refresh_flag == 'ON')
    <div class="send_message_container">
        <div class="refresh">
            <div class="button_container">
                <span class="reception"> <i class="fas fa-broadcast-tower fa-lg"></i> 受信モード</span>
                <div class="on_button">
                    <form action="/Message" method="POST">
                        <input type="submit" name="refresh_flag" value=ON>
                        <input type="hidden" name="user_id" value={{ $my_id }}>
                        <input type="hidden" name="talkroom_id" value={{ $talkroom->id }}>
                        @csrf
                    </form>
                </div>
                <div class="off_button">
                    <form action="/Message" method="POST">
                        <input type="submit" name="refresh_flag" value=OFF>
                        <input type="hidden" name="user_id" value={{ $my_id }}>
                        <input type="hidden" name="talkroom_id" value={{ $talkroom->id }}>
                        @csrf
                    </form>
                </div>
            </div>
        </div>
        <span class="reception"><i class="fas fa-redo-alt fa-spin fa-lg"></i> 受信中</span>
    </div>
@else
    <div class="send_message_container">
        <div class="refresh">
            <div class="button_container">
                <span class="reception"> <i class="fas fa-broadcast-tower fa-lg"></i> 受信モード</span>
                <div class="on_button">
                    <form action="/Message" method="POST">
                        <input type="submit" name="refresh_flag" value=ON>
                        <input type="hidden" name="user_id" value={{ $my_id }}>
                        <input type="hidden" name="talkroom_id" value={{ $talkroom->id }}>
                        @csrf
                    </form>
                </div>
                <div class="off_button">
                    <form action="/Message" method="POST">
                        <input type="submit" name="refresh_flag" value=OFF>
                        <input type="hidden" name="user_id" value={{ $my_id }}>
                        <input type="hidden" name="talkroom_id" value={{ $talkroom->id }}>
                        @csrf
                    </form>
                </div>
            </div>
        </div>
        <form class="send_message" action="/Message/send" method="POST" enctype="multipart/form-data">
            <div class="content_container">
                <label for="file-upload" class="file-upload-label">
                    <i class="fas fa-image fa-lg"></i>
                    <input class="file-upload" type="file">
                </label>
            </div>
            <div>
                <input type="text" name="content">
                <input type="hidden" name="user_id" value={{ $my_id }}>
                <input type="hidden" name="talkroom_id" value={{ $talkroom->id }}><!-- 現在会話しているトークルームのIDを保持 --->
            </div>
            <input type="submit" value="送る">
            @csrf
        </form>
        {{-- エラーメッセージ --}}
        <p>{{ $errors->first('content') }}</p>
    </div>
@endif

@include('footer')

<script>
    window.onload = function() {
        window.scrollTo(0, document.body.scrollHeight);
        document.documentElement.style.visibility = 'visible';
        document.querySelector('.container').style.visibility = 'visible';
    };
</script>
