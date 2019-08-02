<?php
    require('function.php');
    auth();

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

    if (!empty($_GET)) {
        $id=$_GET['user_id'];
        $my_flg=false;
    }else{
        $id=$_SESSION['user_id'];
        $my_flg=true;
    }

    //ユーザー情報の所得
    try{
        $db=getDb();
        $sql='SELECT * FROM users WHERE id = :id';
        $data=[':id'=>$id];
        $result=queryPost($sql,$data,$db);
        $users=$result->fetch(PDO::FETCH_ASSOC);

        $sql='SELECT * FROM texts AS T JOIN teams AS C ON T.id = C.id WHERE T.user_id = :id AND T.delete_flg = 0';
        $data=[':id'=>$id];
        $result=queryPost($sql,$data,$db);
        $texts=$result->fetchAll();

        $sql='SELECT * FROM teams WHERE user_id = :id';
        $data=[':id'=>$id];
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
    <link rel="stylesheet" type="text/css" href="../css/myPage.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <title>Match-Code|マイページ</title>
</head>
<body>
    <?php include('header.php')?>
    <section class="myPage-section">
    <h1 class="msg-suc"><?php if(!empty($_SESSION['msg-suc'])) echo getSession('msg-suc') ?></h1>
        <div class="myPage-container">
            <div class="site-width">
                <h1 class="mypage-title">プロフィール</h1>
                <div class="my-prof">
                    <img class="prof-img" src="<?php echo (!empty($users['img'])) ? $users['img'] :  '../img/sample.jpg'?>">
                    <dl>
                        <dt>名前</dt>
                        <dd><?php echo $users['name']?></dd>
                        <dt>年齢</dt>
                        <dd><?php echo $users['age']?></dd>
                        <dt>種別</dt>
                        <dd><?php echo ($users['type_id'] == 1) ? 'エンジニア' : 'デザイナー'?></dd>
                        <dt>スキル</dt>
                        <dd><?php echo $users['skill']?></dd>
                        <dt>プロフィール</dt>
                        <dd><?php echo $users['prof']?></dd>
                    </dl>
                </div>
                <div class="text-contents">
                    <h1>投稿一覧</h1>
                    <?php foreach($texts as $text){?>
                        <div class="text-content">
                            <a href="postDetail-view.php?id=<?php echo $text['id']?>"><h2><?php echo $text['title']?></h2></a><br/>
                            <p>募集人数:<?php echo $text['number']?>名</p><br/>
                            <p>リーダー:<a href="myPage-view.php?user_id=<?php echo $id?>"><?php echo $users['name']?></a></p><br/>
                            <p>チーム名:<a href="team-detail.php?id=<?php echo $text['id']?>"><?php echo $text['name']?></a></p>
                            <p class="max-height">募集内容:<br/><?php echo $text['text']?></p><br/>
                            <?php if($my_flg) echo '<a class="delete-btn" href="delete-post.php?id='.$text['id'].'">削除</a>'?>
                            <?php if($my_flg) echo '<a class="update-btn" href="update-post.php?id='.$text['id'].'">編集</a>'?>
                        </div>
                    <?php }?>
                </div>
                <div class="team-contents">
                    <h1>所属チーム</h1>
                    <?php foreach($teams as $team){?>
                        <div class="team-content">
                            <a href="teamDetail-view.php?id=<?php echo $team['id']?>"><h2><?php echo $team['name']?></h2></a><br/>
                            <p>リーダー:<a href="myPage-view.php?user_id=<?php echo $id?>"><?php echo $users['name']?></a></p><br/>
                            <p class="max-height">活動内容:<br/><?php echo $team['text']?></p><br/>
                            <?php if($my_flg) echo '<a class="delete-btn" href="delete-team.php?id='.$team['id'].'">削除</a>'?>
                            <?php if($my_flg) echo '<a class="update-btn" href="update-team.php?id='.$team['id'].'">編集</a>'?>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </section>
    <?php include('footer.php')?>
    <script src="../js/index.js"></script>
</body>
</html>