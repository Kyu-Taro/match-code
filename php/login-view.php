<?php
    require_once('function.php');
    debug('てすと');
    
    //ヘッダーとフッターに使うリンク
    $url1="index.php";
    $url2="register-view.php";
    $url3="post-view.php";
    $url4="team-view.php";
    $url5="../html/detail.html";
    $link1="Top";
    $link2="Regist";
    $link3="Post";
    $link4="Team";
    $link5="Detail";

    if(!empty($_POST)){
        debug('POST送信があります');
        error_log('POSTの中身'.print_r($_POST,true));
        $email = $_POST['email'];
        $pass = $_POST['pass'];
        //入力チェック
        emptyCheck($email, 'email');
        emptyCheck($pass, 'pass');
        error_log('errの中身'.print_r($err_msg,true));
        if(empty($err_msg)){
            error_log('入力チェックOKです');

            //email形式チェック
            emailCheck($email, 'email');
            //pass文字数チェック
            passCheckNumber($pass, 'pass');
            //pass半角チェック
            harfCheck($pass, 'pass');
            if(empty($err_msg)){
                error_log('形式チェックOKです');

                //DBからパスワードを持ってくる
                try{
                    $dbh = getDb();
                    $sql = 'SELECT pass, id FROM users WHERE email = :email AND delete_flg = 0';
                    $data = [':email' => $email];
                    $item = queryPost($sql, $data, $dbh);
                    $result = $item->fetch(PDO::FETCH_ASSOC);
                    //パスワードが一致するか確認
                    if($result && password_verify($pass, array_shift($result))){
                        error_log('パスワードが一致しました');
                        //セッションにidとlogin_timeとlogin_limitを入れる
                        $_SESSION['user_id'] = $result['id'];
                        $_SESSION['login_time'] = time();
                        //ログイン保持にチェックがあれば30日、なければ１時間
                        if(!empty($_POST['login'])){
                            $_SESSION['login_limit'] = 60*60*24*30;
                        }else{
                            $_SESSION['login_limit'] = 60*60;
                        }
                        header('Location:myPage-view.php');
                        exit();
                    }else{
                        debug('パスワードが合いません');
                        $err_msg['error'] = 'EmailまたはPasswordが合いません';                        
                    }
                }catch (Exception $e){
                    debug($e->getMessage());
                    $err_msg['error'] = 'エラーが発生しました';
                }

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
    <link rel="stylesheet" href="../css/login.css" type="text/css">
    <title>Match-Code|ログイン</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
</head>
<body>
    <?php include('header.php'); ?>
    <main class="top-container">
        <section class="form-container">
            <div class="site-width">
                <h1>Login</h1>
                <form action="" method="POST">
                   <p class="error"><?php if(!empty($err_msg['error'])) echo $err_msg['error'] ?></p>
                    <label>Email<span class="error"><?php if(!empty($err_msg['email'])) echo $err_msg['email'] ?></span><br/>
                        <input type="text" name="email" value="<?php if(!empty($_POST['email'])) echo $_POST['email'] ?>">
                    </label><br>
                    <label>Password<span class="error"><?php if(!empty($err_msg['pass'])) echo $err_msg['pass'] ?></span><br/>
                        <input type="password" name="pass" value="<?php if(!empty($_POST['pass'])) echo $_POST['pass'] ?>">
                    </label><br>
                    <input type="checkbox" name="login" <?php if(!empty($_POST['login'])) echo 'checked' ?>>ログイン状態を保持する<br/>
                    <input type="submit" value="SEND">
                </form>
            </div>
        </section>
    </main>        
    <?php include('footer.php')?>
    <script src="../js/index.js"></script>
</body>
</html>