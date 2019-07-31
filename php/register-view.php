<?php
    require('function.php');

//ヘッダーとフッターに使うリンク
    $url1="index.php";
    $url2="login-view.php";
    $url3="post-view.php";
    $url4="team-view.php";
    $url5="../html/detail.html";
    $url6="myPage-view.php";
    $link1="Top";
    $link2="Login";
    $link3="Post";
    $link4="Team";
    $link5="Detail";
    $link6="Mypage";

    if(!empty($_POST)){
        //POSTデータを変数に格納
        $name=$_POST['name'];
        $email=$_POST['email'];
        $pass=$_POST['pass'];
        $repass=$_POST['repass'];
        $age=$_POST['age'];
        $type=$_POST['type'];
        $skill=$_POST['skill'];
        $profile=$_POST['profile'];

        //POSTデーターが空ではないかのチェック
        emptyCheck($name,'name');
        emptyCheck($email,'email');
        emptyCheck($pass,'pass');
        emptyCheck($repass,'repass');
        emptyCheck($age,'age');
        emptyCheck($type,'type');
        emptyCheck($skill,'skill');
        emptyCheck($profile,'profile');

        //Emailの形式チェック
        if(empty($err_msg)){
            emailCheck($email,'email');
        }

        //年齢のが数字かどうかのチェック
        if(empty($err_msg)){
            ageCheck($age,'age');
        }

        //パスワードのバリデーションチェック
        if(empty($err_msg)){
            passCheckNumber($pass,'pass');
            harfCheck($pass,'pass');
            passCheck($pass,$repass,'repass');
        }

        //メールアドレスがすでに登録されているものがないか
        if(empty($err_msg)){
            try{
                $db=getDb();
                $sql='SELECT count(*) FROM users WHERE email = :email && delete_flg = 0';
                $data=[':email'=>$email];
                $item=queryPost($sql,$data,$db);
                $result=$item->fetch(PDO::FETCH_ASSOC);
                debug(print_r($result,true));
                if(!empty(array_shift($result))){
                    $err_msg['email']=ERROR6;
                }
            }catch(Exception $e){
                debug('エラー:'.$e->getMessage());
            }
        }

        //全てのバリデーションが終わり画面遷移の操作と会員登録
        if(empty($err_msg)){
            try{
                $db=getDb();
                $sql='INSERT INTO users(name,email,pass,age,type_id,skill,prof) VALUES(:name,:email,:pass,:age,:type_id,:skill,:prof)';
                $data=[':name'=>$name,':email'=>$email,':pass'=>password_hash($pass,PASSWORD_DEFAULT),':age'=>$age,':type_id'=>$type,':skill'=>$skill,':prof'=>$profile];
                $result=queryPost($sql,$data,$db);
                if($result){
                    header('Location:myPage-view.php');
                }
            }catch(Exception $e){
                debug('エラー:'.$e->getMessage());
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
    <link rel="stylesheet" href="../css/register.css" type="text/css">
    <title>Match-Code<|新規登録</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
</head>
<body>
    <?php include('header.php'); ?>
    <main class="top-container">
        <section class="form-container">
            <div class="site-width">
            <h1>会員登録</h1>
                <form action="register-view.php" method="POST">
                        <label>名前<span class="error"><?php if(!empty($err_msg['name'])) echo $err_msg['name']?> </span><br/>
                            <input type="text" name="name" value="<?php if(!empty($_POST['name'])) echo $_POST['name']?>">
                        </label><br>
                        <label>メール<?php if(!empty($err_msg['email'])) echo "<br/>"?><span class="error"><?php if(!empty($err_msg['email'])) echo $err_msg['email']?> </span><br/>
                            <input type="text" name="email" value="<?php if(!empty($_POST['email'])) echo $_POST['email']?>">
                        </label><br>
                        <label>パスワード<?php if(!empty($err_msg['pass']))  echo "<br/>"?><span class="error"><?php if(!empty($err_msg['pass'])) echo $err_msg['pass']?></span><br/>
                            <input type="password" name="pass">
                        </label><br>
                        <label>パスワード再入力<?php if(!empty($err_msg['repass']))  echo "<br/>"?><span class="error"><?php if(!empty($err_msg['repass'])) echo $err_msg['repass']?><br/>
                            <input type="password" name="repass">
                        </label><br>
                        <label>年齢<span class="error"><?php if(!empty($err_msg['age'])) echo $err_msg['age']?></span><br/>
                            <input type="tel" name="age" value="<?php if(!empty($_POST['age'])) echo $_POST['age']?>">
                        </label><br>
                        <label>職種<span class="error"><?php if(!empty($err_msg['type'])) echo $err_msg['type']?></span><br/>
                            <input type="radio" name="type" value="1" <?php if(!empty($_POST['type']) && $_POST['type'] == '1') echo 'checked'?>>エンジニア
                            <input type="radio" name="type" value="2" <?php if(!empty($_POST['type']) && $_POST['type'] == '2') echo 'checked'?>>デザイナー
                        </label><br>
                        <label>スキル<span class="error"><?php if(!empty($err_msg['skill'])) echo $err_msg['skill']?></span><br/>
                        <textarea name="skill" cols=50 rows=5><?php if(!empty($_POST['skill'])) echo $_POST['skill']?></textarea>
                        </label><br>
                        <label>プロフィール<span class="error"><?php if(!empty($err_msg['profile'])) echo $err_msg['profile']?></span><br/>
                            <textarea name="profile" cols=50 rows=5><?php if(!empty($_POST['profile'])) echo $_POST['profile']?></textarea>
                        </label><br>
                    <input type="submit" value="SEND">
                </form>
                <p>アカウントをお持ちの方は<a href="login-view.php">こちら</a></p>
            </div>
        </section>
    </main>        
    <?php include('footer.php')?>
    <script src="../js/index.js"></script>
</body>
</html>