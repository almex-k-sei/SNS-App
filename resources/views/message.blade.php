    @include('header')


    <h1 class="talkroom_title">{{$talkroom->name}}</h1>

    <div class="container">

    @foreach ($messages as $message)
        <div class="message_container">
            @if($my_id == $message->user_id)
                <div class="text_right_container text_container">
                    <p>
                        {{$message->content}}
                        <br>
                        @if(isset($message->filepath))
                        {{-- ファイルの形式を判別する　--}}
                            @if(explode('/',$message->filetype)[0] == "image")
                                <img src="{{$message->filepath}}" width="200px" height="200px">
                            @elseif (explode('/',$message->filetype)[0] == "audio")
                                <audio controls src="{{$message->filepath}}"  type="{{$message->filetype}}"></audio>
                            @elseif (explode('/',$message->filetype)[0] == "video")
                                <video src="{{$message->filepath}}" type="{{$message->filetype}}" width="200px" height="200px"
                                    autoplay muted loop>a</video>
                            @endif
                            <br>
                            <a href="{{$message->filepath}}" download="{{$message->filename}}">ダウンロード</a>
                        @endif
                    </p>
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

    <form class="send_message" action="/Message/send" method="POST" enctype="multipart/form-data">
        <input type="text" name="content">
        <input type="hidden" name="user_id" value={{$my_id}}>
        <input type="hidden" name="talkroom_id" value={{$talkroom->id}}><!-- 現在会話しているトークルームのIDを保持 --->
        <input type="file" name="file" class="">
        <input type="submit" value="送る">
        @csrf
    </form>
    <p>{{ $errors->first('content') }}</p>

  </div>

  @include('footer')

  <script>
    // JavaScriptコードをここに追加する
    window.onload = function() {
        window.scrollTo(0, document.body.scrollHeight);
    };
</script>
