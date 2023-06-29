@include('header')
    {{-- CSS読み込み --}}
    <link rel="stylesheet" href="css/search_friends.css">
</head>
<body>
    <div class="search_friends_container">
        <h2>友達追加</h2>
        
        <!--戻るボタン-->
        <div class="back">
        <a href="/Home"><i class="fas fa-backward"></i></a>
        </div>

        <form action="/search_friend" method="post">
            <input type="text" name="friend_email">
            <input type="submit" value="検索">
            @csrf
        </form>


        <form class="add_friend" action="/add_friend" method="post">
            <img src="{{$results->image}}" alt="">
            {{$results->name}}
            @csrf
            <input type="submit" name="add_friend" value="追加">
            <input type="hidden" name="friend_id" value="{{$friend_id}}">
        </form>
    </div>
    @include('footer')
