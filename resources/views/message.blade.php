{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>メッセージ</title>
    <!-- メッセージ一覧から選択・クリックすると飛ぶフレンド・グループとのチャット履歴についてのview--->
</head>
<body>
 --}}



    {{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel ="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <title>サービス名</title>
</head>
<body>
    <header>
        <div class="header_left">
            <p>サービス名</p>
        </div>
        <div class="header_right">
            <a href=""><i class="far fa-sign-out-alt"></i></a>
        </div>
    </header> --}}

    @include('header')


    <h1>{{$talkroom->name}}</h1>

    <div class="container">

        <div class="message_container">

            @foreach ($messages as $message)
                @if($my_id == $message->user_id)
                    <div class="text_right_container text_container">
                        <p class="my_message">{{$message->user->name}}(自分):{{$message->content}}</p>
                    </div>
                @else
                    <div class="text_left_container text_container">
                        <p class="other_message">{{$message->user->name}}:{{$message->content}}</p>
                    </div>
                @endif
            @endforeach

        </div>

        <form class="send_message" action="" method="POST">
            <input type="text" name="content">
            <input type="hidden" name="user_id" value={{$my_id}}>
            <input type="hidden" name="talkroom_id" value={{$talkroom->id}}>
            <input type="submit" value="送信">
            @csrf
        </form>

    </div>

    @include('footer')
