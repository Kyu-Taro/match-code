<?php
require('function.php');
//ヘッダーとフッターに使うリンク
    $url1="register-view.php";
    $url2="login-view.php";
    $url3="post-view.php";
    $url4="team-view.php";
    $url5="detail.php";
    $url6="myPage-view.php";
    $link1="Regist";
    $link2="Login";
    $link3="Post";
    $link4="Team";
    $link5="Detail";
    $link6="Mypage";
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/index.css" type="text/css">
    <title>Match-Code|トップページ</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
</head>
<body>
    <?php include('header.php'); ?>
    <section class="top-container">
        <h1 class="msg-suc"><?php if(!empty($_SESSION['msg-suc'])) echo getSession('msg-suc') ?></h1>
        <h1 class="top-title">
            ~Match-Code~<br/>
            First time team development
        </h1>
        <p class="top-coment">
            駆け出しプログラマー・デザイナーのためのサービス<br/>
            一人ではできないチーム開発を<span class="top-span">Match-code</span>なら<br/>
            初めてのチーム開発をここで
        </p>
    </section>
    <section class="detail-container">
        <div class="detail-top site-width scroll-section">
            <h1 class="detail-title"><span class="top-span">Match-Code</span>とは</h1>
            <p class="detail-coment">
                独学でプログラミング、デザインを勉強していると<br/>
                一人で作業することがほとんど。<br/>
                誰かと一緒に作ってみたい、チームで制作してみたい<br/>
                そんなあなたの仲間をここで探しませんか?<br/>
            </p>
            <a href="register-view.php" class="detail-link">Let's develop</a>
        </div>
    </section>
    <section class="usage-container">
        <div class="usage-top site-width scroll-section">
            <h1 class="usage-title">ご利用について</h1>
            <p class="usage-coment">
                完全無料で全ての機能をお使い頂けます<br/>
                会員登録を行いチームの作成やチーム参加を行えます<br/>
                また、募集チームの回覧、チームのメンバーの確認など<br/>
                チーム参加からチーム作成、開発までの流れを以下で確認できます<br/>
            </p>
            <a href="detail.php" class="detail-link">Click here for details</a>
        </div>
    </section>
    <?php include('footer.php')?>
    <script src="js/index.js"></script>
</body>
</html>
