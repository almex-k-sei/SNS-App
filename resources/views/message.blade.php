    @include('header')


    <h1>{{$talkroom->name}}</h1>

    <div class="container">

    @foreach ($messages as $message)
        <div class="message_container">
            @if($my_id == $message->user_id)
                <div class="text_right_container text_container">
                    <p>{{$message->content}}</p>
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

  </div>

  @include('footer')

  <script>
    // JavaScriptコードをここに追加する
    window.onload = function() {
        window.scrollTo(0, document.body.scrollHeight);
    };
</script>
