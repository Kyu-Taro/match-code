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

        $sql='SELECT T.id,T.title,T.number,T.text AS text_name,C.name FROM texts AS T JOIN teams AS C ON T.id = C.id WHERE T.user_id = :id AND T.delete_flg = 0';
        $data=[':id'=>$id];
        $result=queryPost($sql,$data,$db);
        $texts=$result->fetchAll();

        $sql='SELECT T.id AS id,T.name AS team_name,U.name AS name,T.text AS text FROM affiliation AS A JOIN teams AS T ON A.team_id = T.id AND T.delete_flg = 0 AND A.user_id = :user_id JOIN users AS U ON T.user_id = U.id';
        $data=[':user_id'=>$id];
        $result=queryPost($sql,$data,$db);
        $teams=$result->fetchAll();

        $sql='SELECT U.name AS name,T.name AS team_name,A.id AS id,U.id AS user_id,T.id AS team_id FROM entory AS A JOIN users AS U ON A.eh_id = U.id AND A.delete_flg = 0 AND decision = 0 JOIN teams AS T ON A.pj_id = T.id AND A.rd_id = :id';
        $data=[':id'=>$id];
        $result=queryPost($sql,$data,$db);
        $items=$result->fetchAll();
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
                        <dd><?php echo sani($users['name'])?></dd>
                        <dt>年齢</dt>
                        <dd><?php echo sani($users['age'])?></dd>
                        <dt>種別</dt>
                        <dd><?php echo ($users['type_id'] == 1) ? 'エンジニア' : 'デザイナー'?></dd>
                        <dt>スキル</dt>
                        <dd><?php echo sani($users['skill'])?></dd>
                        <dt>プロフィール</dt>
                        <dd><?php echo sani($users['prof'])?></dd>
                    </dl>
                </div>
                <div class="team-contents">
                    <h1>所属チーム</h1>
                    <div class="content-wrap">
                        <?php foreach($teams as $team){?>
                            <div class="team-content">
                                <a href="teamDetail-view.php?id=<?php echo $team['id']?>"><h2 class="max-height"><?php echo sani($team['team_name'])?></h2></a><br/>
                                <p class="max-height">リーダー:<a href="myPage-view.php?user_id=<?php echo $id?>"><?php echo sani($users['name'])?></a></p><br/>
                                <p class="max-height2">活動内容:<br/><?php echo sani($team['text'])?></p><br/>
                                <?php if($my_flg) echo '<a class="delete-btn" href="delete-team.php?id='.$team['id'].'">削除</a>'?>
                                <?php if($my_flg) echo '<a class="update-btn" href="update-team.php?id='.$team['id'].'">編集</a>'?>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="text-contents">
                    <h1>募集中</h1>
                    <div class="content-wrap">
                        <?php foreach($texts as $text){?>
                            <div class="text-content">
                                <a href="postDetail-view.php?id=<?php echo $text['id']?>"><h2 class="max-height"><?php echo sani($text['title'])?></h2></a><br/>
                                <p class="max-height">募集人数:<?php echo $text['number']?>名</p><br/>
                                <p class="max-height">リーダー:<a href="myPage-view.php?user_id=<?php echo $id?>"><?php echo sani($users['name'])?></a></p><br/>
                                <p class="max-height">チーム名:<a href="teamDetail-view.php?id=<?php echo $text['id']?>"><?php echo sani($text['name'])?></a></p>
                                <p class="max-height2">募集内容:<br/><?php echo $text['text_name']?></p><br/>
                                <?php if($my_flg) echo '<a class="delete-btn" href="delete-post.php?id='.$text['id'].'">削除</a>'?>
                                <?php if($my_flg) echo '<a class="update-btn" href="update-post.php?id='.$text['id'].'">編集</a>'?>
                            </div>
                        <?php }?>
                    </div>
                </div>
                <?php if($my_flg){?>
                <div class="entory-contents">
                    <h1>申請者一覧</h1>
                    <div class="content-wrap">
                        <?php foreach($items as $item){?>
                            <div class="entory-content">
                                <a href="teamDetail-view.php?id=<?php echo $item['team_id']?>"><h2 class="max-height"><?php echo sani($item['team_name'])?></h2></a><br/>
                                申請者:<a href="myPage-view.php?user_id=<?php echo $item['user_id']?>"><h2 class="max-height"><?php echo sani($item['name'])?></h2></a><br/>
                                <?php if($my_flg) echo '<a class="delete-btn" href="delete-post.php?id='.$text['id'].'">承諾</a>'?>
                                <?php if($my_flg) echo '<a class="update-btn" href="update-post.php?id='.$text['id'].'">断る</a>'?>
                            </div>
                        <?php }?>
                    </div>
                </div>
                <?php }?>
            </div>
        </div>
    </section>
    <?php include('footer.php')?>
    <script src="../js/index.js"></script>
</body>
</html>