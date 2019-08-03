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
        $id=$_POST['id'];
        $name=$_POST['name'];
        $email=$_POST['email'];
        $age=$_POST['age'];
        $type=$_POST['type'];
        $skill=$_POST['skill'];
        $prof=$_POST['prof'];
        $img=$_FILES['file'];

        emptyCheck($name,'name');
        emptyCheck($email,'email');
        emptyCheck($age,'age');
        emptyCheck($type,'type');
        emptyCheck($skill,'skill');
        emptyCheck($prof,'prof');

        if(empty($err_msg)){
            emailCheck($email,'email');
            ageCheck($age,'age');
        }

        if(empty($err_msg)){
            $path=uploadImg($img,'file');
            if($path == 'no-file'){
                $path =$users['img'];
            }
        }

        if(empty($err_msg)){
            try{
                $db=getDb();
                $sql='UPDATE users SET name = :name,email = :email,age = :age,type_id = :type,skill = :skill,prof = :prof,img = :img WHERE id = :id';
                $data=[':name'=>$name,':email'=>$email,'age'=>$age,':type'=>$type,':skill'=>$skill,':prof'=>$prof,':img'=>$path,':id'=>$id];
                $result=queryPost($sql,$data,$db);
                if($result){
                    $_SESSION['msg-suc']='プロフィールを更新しました';
                    header('Location:myPage-view.php');
                }
            }catch(Exception $e){
                debug('更新時にエラーが発生しました'.$e->getMessage());
            }
        }
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
                <form action="setting.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?php echo $_SESSION['user_id']?>">
                    <label>プロフィール画像<span class="error"><?php echo errMsg('file') ?></span><br/>
                    <div class="area-drop">
                        ドラッグ&ドロップ
                        <img src="<?php if(!empty($users['img'])) echo $users['img']?>" class="prev-img" style="<?php (!empty($users['img'])) ? 'display:block' : 'display: none'?>">
                        <input type="file" name="file" class="input-file"><br/>
                    </div>
                    </label>
                    <label>名前:<span class="error"><?php echo errMsg('name') ?></span><br/>
                        <input type="text" name="name" value="<?php echo getPost('name') ?>"><br/>
                    </label>
                    <label>メールアドレス:<span class="error"><?php echo errMsg('email') ?></span><br/>
                        <input type="text" name="email" value="<?php echo getPost('email') ?>"><br/>
                    </label>
                    <label>年齢:<span class="error"><?php echo errMsg('age') ?></span><br/>
                        <input type="tel" name="age" value="<?php  echo getPost('age') ?>"><br/>
                    </label>
                    <label>種別:<span class="error"><?php echo errMsg('type') ?></span><br/>
                        <input type="radio" name="type" value="1" <?php if($users['type_id'] == '1') echo 'checked'?>>エンジニア
                        <input type="radio" name="type" value="2" <?php if($users['type_id'] == '2') echo 'checked'?>>デザイナー<br/>
                    </label>
                    <label>スキル:<span class="error"><?php echo errMsg('skill') ?></span><br/>
                        <textarea cols="50" rows="5" name="skill"><?php echo getPost('skill') ?></textarea><br/>
                    </label>
                    <label>自己紹介<span class="error"><?php echo errMsg('prof') ?></span><br/>
                        <textarea cols="50" rows="5" name="prof"><?php echo getPost('prof') ?></textarea><br/>
                    </label>
                    <input type="submit" value="SEND">
                </form>
                <span class="delete">退会は<a href="delete-view.php">こちら</a></span>
            </div>
        </div>
    </section>
    <?php include('footer.php')?>
    <script src="../js/index.js"></script>
</body>
</html>