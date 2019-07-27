<?php
    require('function.php');

//ヘッダーとフッターに使うリンク
    $url1="index.php";
    $url2="login-view.php";
    $url3="post-view.php";
    $url4="team-view.php";
    $url5="../html/detail.html";
    $link1="Top";
    $link2="Login";
    $link3="Post";
    $link4="Team";
    $link5="Detail";

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
            passCheck($pass,$repass,'repass');
            passCheckNumber($repass,'repass');
            passCheckNumber($pass,'pass');
        }

        //メールアドレスがすでに登録されているものがないか
        if(empty($err_msg)){
            try{
                $db=getDb();
                $sql='SELECT * FROM users WHERE email = :email';
                $data=[':email'=>$email];
                $item=queryPost($sql,$data,$db);
                if($item){
                    $err_msg['email']=ERROR6;
                }
            }catch(Exception $e){
                
            }
        }

        //全てのバリデーションが終わり画面遷移の操作
        if(empty($err_msg)){
            header('Location:myPage-view.php');
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
    <title>Match-Code</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
</head>
<body>
    <?php include('header.php'); ?>
    <main class="top-container">
        <section class="form-container">
            <div class="site-width">
            <h1>Member registration</h1>
                <form action="register-view.php" method="POST">
                        <label>Name<span class="error"><?php if(!empty($err_msg['name'])) echo $err_msg['name']?> </span><br/>
                            <input type="text" name="name" value="<?php if(!empty($_POST['name'])) echo $_POST['name']?>">
                        </label><br>
                        <label>Email<span class="error"><?php if(!empty($err_msg['email'])) echo $err_msg['email']?> </span><br/>
                            <input type="text" name="email" value="<?php if(!empty($_POST['email'])) echo $_POST['email']?>">
                        </label><br>
                        <label>Password<?php if(!empty($err_msg['pass']))  echo "<br/>"?><span class="error"><?php if(!empty($err_msg['pass'])) echo $err_msg['repass']?></span><br/>
                            <input type="password" name="pass">
                        </label><br>
                        <label>Retype password<?php if(!empty($err_msg['repass']))  echo "<br/>"?><span class="error"><?php if(!empty($err_msg['repass'])) echo $err_msg['repass']?><br/>
                            <input type="password" name="repass">
                        </label><br>
                        <label>Age<span class="error"><?php if(!empty($err_msg['age'])) echo $err_msg['age']?></span><br/>
                            <input type="tel" name="age" value="<?php if(!empty($_POST['age'])) echo $_POST['age']?>">
                        </label><br>
                        <label>Type<span class="error"><?php if(!empty($err_msg['type'])) echo $err_msg['type']?></span><br/>
                            <input type="radio" name="type" value="engineer" <?php if(!empty($_POST['type']) && $_POST['type'] == 'engineer') echo 'checked'?>>エンジニア
                            <input type="radio" name="type" value="designer" <?php if(!empty($_POST['type']) && $_POST['type'] == 'designer') echo 'checked'?>>デザイナー
                        </label><br>
                        <label>Skill<span class="error"><?php if(!empty($err_msg['skill'])) echo $err_msg['skill']?></span><br/>
                        <textarea name="skill" cols=50 rows=5><?php if(!empty($_POST['skill'])) echo $_POST['skill']?></textarea>
                        </label><br>
                        <label>Profile<span class="error"><?php if(!empty($err_msg['profile'])) echo $err_msg['profile']?></span><br/>
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