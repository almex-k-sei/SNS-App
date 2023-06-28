    @include('header')

    <h1 class="talkroom_title">
        <div class="back">
            <a href="/MessageList"><i class="fas fa-backward"></i></a>
        </div>
        @if ($talkroom->name == "")
            @foreach ($talkroom->user as $user)
                @if ($user->id != $my_id)
                <i class="fas fa-user"></i> {{$user->profile->name}}
                @endif
            @endforeach
        @else
            <i class="fas fa-users"></i> {{$talkroom->name}}
        @endif
        <div class="memo">
            <details>
                <summary><i class="far fa-sticky-note"></i></summary>
                @if ($memo == NULL)
                    <form action="Message/add_memo" method="POST">
                        <textarea name="content" cols="30" rows="10"></textarea>
                        <input type="submit" value="メモを保存">
                        <input type="hidden" name="talkroom_id" value={{$talkroom->id}}>
                        <input type="hidden" name="user_id" value={{$my_id}}>
                        @csrf
                    </form>
                @else
                    <form action="Message/update_memo" method="POST">
                        <textarea name="content" cols="30" rows="10">{{$memo->content}}</textarea>
                        <input type="submit" value="メモを保存">
                        <input type="hidden" name="talkroom_id" value={{$talkroom->id}}>
                        <input type="hidden" name="user_id" value={{$my_id}}>
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
                $ymd = date("Y/m/d", $timestamp);
                $hm = date("H:i", $timestamp);
            ?>
            @if ($previous_ymd == 0)
                {{$ymd}}
                <?php $previous_ymd = $ymd ?>
            @elseif ($previous_ymd != $ymd)
                {{$ymd}}
                <?php $previous_ymd = $ymd ?>
            @endif
        </p>
        <div class="message_container">
            @if($my_id == $message->user_id)
                <div class="text_right_container text_container">
                    <div class="time_bottom right">
                        <p>
                            {{-- メッセージが格納されているか判別 --}}
                            @if(isset($message->content))
                                {{$message->content}}
                                <br>
                            @endif
                            {{-- ファイルデータが格納されているか判別 --}}
                            @if(isset($message->filepath))
                                {{-- ファイルの形式を判別する　--}}
                                @if(explode('/',$message->filetype)[0] == "image")
                                    <img src="{{$message->filepath}}" width="200px" height="200px">
                                @elseif (explode('/',$message->filetype)[0] == "audio")
                                    <audio controls src="{{$message->filepath}}"  type="{{$message->filetype}}"></audio>
                                @elseif (explode('/',$message->filetype)[0] == "video")
                                    <video src="{{$message->filepath}}" type="{{$message->filetype}}" width="200px" height="200px"
                                        autoplay muted loop></video>
                                @endif
                                <br>
                                <a href="{{$message->filepath}}" download="{{$message->filename}}"><i class="fas fa-file-download"></i></a>
                            @endif
                        </p>
                        {{-- 送信時間 --}}
                        {{$hm}}
                    </div>
                    <img src="{{$message->user->profile->image}}" width="50px" height="50px">
            @else
                <div class="text_left_container text_container">
                    {{$message->user->profile->name}}
                    <img src="{{$message->user->profile->image}}" width="50px" height="50px">
                    <div class="time_bottom left">
                        <p>{{$message->content}}</p>
                        {{-- 送信時間 --}}
                        {{$hm}}
                    </div>
            @endif
            </div>
        </div>
        @endforeach

    <div class="send_message_container">
    <form class="send_message" action="/Message/send" method="POST" enctype="multipart/form-data">
        <input type="text" name="content">
        <input type="hidden" name="user_id" value={{$my_id}}>
        <input type="hidden" name="talkroom_id" value={{$talkroom->id}}><!-- 現在会話しているトークルームのIDを保持 --->
        <input type="file" name="file" class="upload_file">
        <input type="submit" value="送る">
        @csrf
    </form>
    {{-- エラーメッセージ --}}
    <p>{{ $errors->first('content') }}</p>
    </div>


  @include('footer')

  <script>
    window.onload = function() {
        // ページの高さを取得
        var pageHeight = document.body.scrollHeight;

        // ビューポートの高さを取得
        var viewportHeight = window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight;

        // ページの高さがビューポートの高さよりも大きい場合にのみスクロール
        if (pageHeight > viewportHeight) {
            window.scrollTo(0, pageHeight);
        }
    };
</script>
