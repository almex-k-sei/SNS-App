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

        <form class="send_message" action="" method="POST">
            <input type="text" name="content">
            <input type="hidden" name="user_id" value={{$my_id}}>
            <input type="hidden" name="talkroom_id" value={{$talkroom->id}}>
            <input type="submit" value="送る">
            @csrf
        </form>

    </div>

    @include('footer')
