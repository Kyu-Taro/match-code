<?php
    require('function.php');
    auth();

    //ヘッダーとフッターのリンク
    $url1="Logout.php";
    $url2="create-view.php";
    $url3="myPage-view.php";
    $url4="post-view.php";
    $url5="detail.php";
    $url6="setting.php";
    $link1="Logout";
    $link2="Create";
    $link3="Mypage";
    $link4="Post";
    $link5="Detail";
    $link6="Setting";

    //ユーザー情報の所得
    try{
        $db=getDb();
        $sql='SELECT T.id,T.name,T.text,U.name AS user_name,U.id AS user_id FROM teams AS T JOIN users AS U ON T.user_id = U.id AND T.delete_flg = 0';
        $data=[];
        $result=queryPost($sql,$data,$db);
        $teams=$result->fetchAll();
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
    <link rel="stylesheet" type="text/css" href="../css/team.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <title>Match-Code|マイページ</title>
</head>
<body>
    <?php include('header.php')?>
    <section class="team-section">
    <h1 class="msg-suc"><?php if(!empty($_SESSION['msg-suc'])) echo getSession('msg-suc') ?></h1>
        <div class="team-container">
            <div class="site-width">
                <div class="team-contents">
                    <h1>チーム一覧</h1>
                    <div class="content-wrap">
                        <?php foreach($teams as $team){?>
                            <div class="team-content">
                                <a href="postDetail-view.php?id=<?php echo $team['id']?>"><h2 class="max-height"><?php echo sani($team['name'])?></h2></a><br/>
                                <p class="max-height">リーダー:<a href="myPage-view.php?user_id=<?php echo $team['user_id']?>"><?php echo sani($team['user_name'])?></a></p><br/>
                                <p class="max-height">チーム名:<a href="teamDetail-view.php?id=<?php echo $team['id']?>"><?php echo sani($team['name'])?></a></p>
                                <p class="max-height2">募集内容:<br/><?php echo $team['text']?></p><br/>
                            </div>
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