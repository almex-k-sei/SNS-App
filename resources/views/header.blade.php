<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel ="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    {{-- サイトアクセス時にresourceフォルダの中にあるブレードファイルを
    ルートやcontrollerで読みに行かせる場合もlinkのパスはpublic内に
    あるものとして記述する。 --}}
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="css/message_main.css">
    <title>サービス名</title>
</head>
<body>
    <header>
        <div class="header_left">
            <p class="service_title">サービス名</p>
        </div>
        <div class="header_right">
            <a href="">
            </a>
        </div>
        <div class="header_left">
            <!--ロゴ画像-->
            <img src="" alt="">
        </div>
        <div class="header_right">
            <!--ログアウト-->
            {{Auth::user()->name}}
            <form action="{{route('logout')}}" method="post">
                <button type="submit">
                <i class="fas fa-sign-out-alt"></i>
                </button>
            @csrf
            </form>
        
    </header>
<!-- </body>
</html> -->
