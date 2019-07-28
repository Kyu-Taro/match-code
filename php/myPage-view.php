<?php
    //ヘッダーとフッターのリンク
    $url1="Logout.php";
    $url2="create-view.php";
    $url3="post-view.php";
    $url4="team-view.php";
    $url5="../html/detail.html";
    $url6="setting.php";
    $link1="Logout";
    $link2="Create";
    $link3="Post";
    $link4="Team";
    $link5="Detail";
    $link6="Setting";

    require('function.php');
    $id=$_SESSION['user_id'];

    //ユーザー情報の所得
    try{
        $db=getDb();
        $sql='SELECT * FROM users WHERE id = :id';
        $data=[':id'=>$id];
        $result=queryPost($sql,$data,$db);
        $items=$result->fetch(PDO::FETCH_ASSOC);
    }catch(Exception $e){
        debut('ユーザー情報所得エラー:'.$e->getMessage());
    }s
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="../css/myPage.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <title>Match-Code|マイページ</title>
</head>
<body>
    <?php include('header.php')?>
    <section class="myPage-section">
        <div class="myPage-container">

        </div>
    </section>
    <?php include('footer.php')?>
    <script src="../js/index.js"></script>
</body>
</html>