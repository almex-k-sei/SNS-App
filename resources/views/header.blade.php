<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- Googleフォントの読み込み --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@400;700&display=swap" rel="stylesheet">
    {{-- fontawesomeの読み込み --}}
    <link rel ="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    {{-- サイトアクセス時にresourceフォルダの中にあるブレードファイルをルートやcontrollerで
    読みに行かせる場合もlinkのパスはpublic内あるものとして記述する。 --}}
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="/css/home_main.css">
    <link rel="stylesheet" href="css/message_main.css">
    <link rel="stylesheet" href="css/message_list.css">
    <link rel="stylesheet" href="css/group_list.css">
    <title>サービス名</title>
</head>
<body>
    <header>
        <div class="header_left">
            <!--ロゴ画像-->
            <img id="logo" src="unnamed.png" alt="ロゴ画像">

        </div>
        {{-- <div class="header_right">
            <a href="">
            </a>
        </div>
        <div class="header_left">
            <!--ロゴ画像-->
            <img src="unnamed.png" alt="ロゴ画像">
        </div> --}}
        <div class="header_right">
            <!--ログアウト-->
            {{Auth::user()->name}}
            <form action="{{route('logout')}}" method="post">
                <button class="logout" type="submit">
                <i class="fas fa-sign-out-alt"></i>
                </button>
            @csrf
            </form>

    </header>
<!-- </body>
</html> -->
