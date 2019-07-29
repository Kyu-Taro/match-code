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
    }else{
        $id=$_SESSION['user_id'];
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
        <div class="myPage-container">
            <div class="site-width">
                <h1 class="mypage-title">Profile</h1>
                <div class="my-prof">
                    <img class="prof-img" src="../img/<?php echo (!empty($users['imgs'])) ? $users['img'] :  'sample.jpg'?>">
                    <dl>
                        <dt>Name</dt>
                        <dd><?php echo $users['name']?></dd>
                        <dt>Age</dt>
                        <dd><?php echo $users['age']?></dd>
                        <dt>Type</dt>
                        <dd><?php echo ($users['type_id'] == 1) ? 'エンジニア' : 'デザイナー'?></dd>
                        <dt>Skill</dt>
                        <dd><?php echo $users['skill']?></dd>
                        <dt>Profile</dt>
                        <dd><?php echo $users['prof']?></dd>
                    </dl>
                </div>
                <div class="text-contents">
                    <h1>Posts</h1>
                    <?php foreach($texts as $text){?>
                        <div class="text-content">
                            <a href="text-detai.php?id=<?php echo $text['id']?>"><h2><?php echo $text['title']?></h2></a><br/>
                            <p>募集人数:<?php echo $text['number']?>名</p><br/>
                            <p>リーダー:<a href="myPage-view.php?user_id=<?php echo $id?>"><?php echo $users['name']?></a></p><br/>
                            <p>チーム名:<a href="team-detail.php?id=<?php echo $text['id']?>"><?php echo $text['name']?></a></p>
                            <p>募集内容:<br/><?php echo $text['text']?></p><br/>
                        </div>
                    <?php }?>
                </div>
                <div class="team-contents">
                    <h1>Teams</h1>
                    <?php foreach($teams as $team){?>
                        <div class="team-content">
                            <a href="team-detail.php?id=<?php echo $team['id']?>"><h2><?php echo $team['name']?></h2></a><br/>
                            <p>リーダー:<a href="myPage-view.php?user_id=<?php echo $id?>"><?php echo $users['name']?></a></p><br/>
                            <p>活動内容:<br/><?php echo $team['text']?></p><br/>
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