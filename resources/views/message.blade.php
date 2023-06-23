    @include('header')


    <h1 class="talkroom_title">
        <div class="back">
            <a href="/MessageList">戻る</a>
        </div>
        @if ($talkroom->name == "")
            @foreach ($talkroom->user as $user)
                @if ($user->id != $my_id)
                    {{$user->name}}　
                @endif
            @endforeach
        @else
            {{$talkroom->name}}
        @endif
    </h1>

    <div class="container">

    @foreach ($messages as $message)
        <div class="message_container">
            @if($my_id == $message->user_id)
                <div class="text_right_container text_container">
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
                    {{$message->updated_at}}
                    <img src="{{$message->user->profile->image}}" width="50px" height="50px">
            @else
                <div class="text_left_container text_container">
                    {{$message->user->profile->name}}
                    <img src="{{$message->user->profile->image}}" width="50px" height="50px">
                    <p>{{$message->content}}</p>
            @endif
            </div>
        </div>
        @endforeach

    <div class="send_message_container">
    <form class="send_message" action="/Message/send" method="POST" enctype="multipart/form-data">
        <input type="text" name="content">
        <input type="hidden" name="user_id" value={{$my_id}}>
        <input type="hidden" name="talkroom_id" value={{$talkroom->id}}><!-- 現在会話しているトークルームのIDを保持 --->
        <input type="file" name="file" class="">
        <input type="submit" value="送る">
        @csrf
    </form>
    {{-- エラーメッセージ --}}
    <p>{{ $errors->first('content') }}</p>
    </div>


  @include('footer')

  <script>
    // JavaScriptコードをここに追加する
    window.onload = function() {
        window.scrollTo(0, document.body.scrollHeight);
    };
</script>
