<?php
    require('function.php');
    auth();

    //ヘッダーとフッターのリンク
    $url1="Logout.php";
    $url2="create-view.php";
    $url3="myPage-view.php";
    $url4="team-view.php";
    $url5="detail.php";
    $url6="setting.php";
    $link1="Logout";
    $link2="Create";
    $link3="Mypage";
    $link4="Team";
    $link5="Detail";
    $link6="Setting";

    //ユーザー情報の所得
    try{
        $db=getDb();
        $sql='SELECT T.id,U.id AS user_id,T.title,T.number,U.name,C.name AS team_name,T.text FROM texts AS T JOIN teams AS C ON T.id = C.id JOIN users AS U ON T.user_id = U.id AND T.delete_flg = 0';
        $data=[];
        $result=queryPost($sql,$data,$db);
        $texts=$result->fetchAll();
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
    <link rel="stylesheet" type="text/css" href="css/post.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <title>Match-Code|マイページ</title>
</head>
<body>
    <?php include('header.php')?>
    <section class="post-section">
    <h1 class="msg-suc"><?php if(!empty($_SESSION['msg-suc'])) echo getSession('msg-suc') ?></h1>
        <div class="post-container">
            <div class="site-width">
                <div class="text-contents">                    
                    <h1>投稿一覧</h1>
                    <div class="content-wrap">
                        <?php foreach($texts as $text){?>
                            <div class="text-content">
                                <a href="postDetail-view.php?id=<?php echo $text['id']?>"><h2 class="max-height"><?php echo sani($text['title'])?></h2></a><br/>
                                <p class="max-height">募集人数:<?php echo $text['number']?>名</p><br/>
                                <p class="max-height">リーダー:<a href="myPage-view.php?user_id=<?php echo $text['user_id']?>"><?php echo sani($text['name'])?></a></p><br/>
                                <p class="max-height">チーム名:<a href="teamDetail-view.php?id=<?php echo $text['id']?>"><?php echo sani($text['team_name'])?></a></p>
                                <p class="max-height2">募集内容:<br/><?php echo $text['text']?></p><br/>
                            </div>
                        <?php }?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php include('footer.php')?>
    <script src="js/index.js"></script>
</body>
</html>