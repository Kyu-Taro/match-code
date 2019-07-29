<?php
    require('function.php');
    auth();

    //ヘッダーとフッターのリンク
    $url1="Logout.php";
    $url2="create-view.php";
    $url3="post-view.php";
    $url4="team-view.php";
    $url5="../html/detail.html";
    $url6="myPage-view.php";
    $link1="Logout";
    $link2="Create";
    $link3="Post";
    $link4="Team";
    $link5="Detail";
    $link6="Mypage";

    //プロフィール情報所得
    try{
        $db=getDb();
        $sql='SELECT * FROM users WHERE id = :id';
        $data=[':id'=>$_SESSION['user_id']];
        $result=queryPost($sql,$data,$db);
        $users=$result->fetch(PDO::FETCH_ASSOC);
    }catch(Exception $e){
        debug('ユーザー情報所得エラー:'.$e->getMessage());
    }

    if(!empty($_POST)){

    }
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="../css/setting.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <title>Match-Code|設定</title>
</head>
<body>
    <?php include('header.php')?>
    <section class="setting-containers">
        <div class="setting-container">
            <div class="site-width">
                <form action="setting.php" method="POST">
                    <label>プロフィール画像<span class="error"></span><br/>
                    <div class="area-drop">
                        ドラッグ&ドロップ
                        <img src="" class="prev-img" style="display: none">
                        <input type="file" name="file" class="input-file"><br/>
                    </div>
                    </label>
                    <label>名前:<span class="error"></span><br/>
                        <input type="text" name="text" value="<?php echo sani($users['name'])?>"><br/>
                    </label>
                    <label>メールアドレス:<span class="error"></span><br/>
                        <input type="text" name="email" value="<?php echo sani($users['email'])?>"><br/>
                    </label>
                    <label>年齢:<span class="error"></span><br/>
                        <input type="tel" name="age" value="<?php echo sani($users['age'])?>"><br/>
                    </label>
                    <label>種別:<span class="error"></span><br/>
                        <input type="radio" name="type" value="1" <?php if($users['type_id'] == '1') echo 'checked'?>>エンジニア
                        <input type="radio" name="type" value="2" <?php if($users['type_id'] == '2') echo 'checked'?>>デザイナー<br/>
                    </label>
                    <label>スキル:<span class="error"></span><br/>
                        <textarea cols="50" rows="5" name="skill"><?php echo sani($users['skill'])?></textarea><br/>
                    </label>
                    <label>自己紹介<span class="error"></span><br/>
                        <textarea cols="50" rows="5" name="prof"><?php echo sani($users['prof'])?></textarea><br/>
                    </label>
                    <input type="submit" value="SEND">
                </form>
            </div>
        </div>
    </section>
    <?php include('footer.php')?>
    <script src="../js/index.js"></script>
</body>
</html>