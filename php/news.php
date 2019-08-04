<?php
    require('function.php');
    auth();

    //ヘッダーとフッターのリンク
    $url1="Logout.php";
    $url2="create-view.php";
    $url3="myPage-view.php";
    $url4="team-view.php";
    $url5="../html/detail.html";
    $url6="setting.php";
    $link1="Logout";
    $link2="Create";
    $link3="Mypage";
    $link4="Team";
    $link5="Detail";
    $link6="Setting";

    $user_id=$_SESSION['user_id'];

    //ユーザー情報の所得
    try{
        $db=getDb();
        $sql='SELECT U.id AS id,U.name,U.email,E.updated_at FROM entory AS E JOIN users AS U ON E.eh_id = U.id AND rd_id = :id AND decision = 1 ORDER BY  created_at DESC';
        $data=['id'=>$user_id];
        $result=queryPost($sql,$data,$db);
        $permissions=$result->fetchAll();
    }catch(Exception $e){
        debug('ユーザー情報所得エラー:'.$e->getMessage());
    }
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="../css/news.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <title>Match-Code|お知らせ</title>
</head>
<body>
    <?php include('header.php')?>
    <section class="post-section">
    <h1 class="msg-suc"><?php if(!empty($_SESSION['msg-suc'])) echo getSession('msg-suc') ?></h1>
        <div class="post-container">
            <div class="site-width">
                <div class="text-contents">                    
                    <h1>お知らせ一覧</h1>
                    <div class="content-wrap">
                        <?php foreach($permissions as $permission){?>
                            <div class="text-content">
                                <p>【<?php echo date('Y/m/d H:i',strtotime($permission['updated_at']))?>】  参加申請のあった<a href="myPage-view.php?user_id=<?php echo $permission['id']?>"><?php echo $permission['name']?></a>さんの申請を許可しました。<span class="color"><?php echo $permission['email']?></span>に連絡をしましょう。</p> </div>
                        <?php }?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php include('footer.php')?>
    <script src="../js/index.js"></script>
</body>
</html>