<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
    <!--IEブラウザ対策-->
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="ページの内容を表す文章" />
    <title></title>
    <link rel="stylesheet" href="{{asset('css/reset.css')}}">
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <link rel="stylesheet" href="{{asset('css/app.css')}}">

    <!--  フォント  -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">

    <!--   jquery  -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/velocity/1.0.0/velocity.min.js"></script>

    <!--スマホ,タブレット対応-->
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <!--サイトのアイコン指定-->
    <link rel="icon" href="画像URL" sizes="16x16" type="image/png" />
    <link rel="icon" href="画像URL" sizes="32x32" type="image/png" />
    <link rel="icon" href="画像URL" sizes="48x48" type="image/png" />
    <link rel="icon" href="画像URL" sizes="62x62" type="image/png" />
    <!--iphoneのアプリアイコン指定-->
    <link rel="apple-touch-icon-precomposed" href="画像のURL" />
    <!--OGPタグ/twitterカード-->
</head>
<body>
    <header>
        <div id = "head">
        <h1><a href="/top"><img src="{{ asset('images/main_logo.png') }}" alt=""></a></h1>
            <div id="pulldawn-menu">
                <div id="dawn">
                    <ul>
                        <li><p>{{ $username }}さん</p>
                        <div class="arrow"></div>
                        <img src="{{ asset('images/'.$images) }}">


                           <!--   オンクリックで表示する  -->
                             <ul class="sub-menu">
                                 <li><a href="/top">ホーム</a></li>
                                 <li><a href="/profile">プロフィール</a></li>
                                 <li><a href="/logout">ログアウト</a></li>
                             </ul>
                        
                        </li>
                       
                       
                    </ul>
                   
                <div>
                
            </div>
        </div>
    </header>

    
    <div id="row">
        <div id="container">
            @yield('content')
        </div >
        <div id="side-bar">
            <div id="confirm">
                <p>{{ $username }}さんの</p>
                <div class="follow">
                <p>フォロー数</p>
                <p>{{count($follower_user)}}名</p>
                </div>
                <p class="btn"><a href="/follow-list">フォローリスト</a></p>
                <div class="follow">
                <p>フォロワー数</p>
                <p>{{count($following_user)}}名</p>
                </div>
                <p class="btn"><a href="/follower-list">フォロワーリスト</a></p>
            </div>
            <p class="btn"><a href="/users/search">ユーザー検索</a></p>
        </div>
    </div>
    <footer>
    </footer>
    

    <script type="text/javascript">
       $(function(){
       $('#dawn ul > li').click(function() {
       $(this).children('ul').slideToggle();
     });
     });


      $(".arrow").on("click", function () {
      $(this).toggleClass("rotate");
      });


    </script>


   




</body>
</html>