<?php
    require_once('function.php');
    
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
        // error_log('POST送信があります');
        // error_log('POSTの中身'.print_r($_POST[],true));

        $email = $_POST['email'];
        $pass = $_POST['passwoed'];
        //入力チェック
        emptyCheck($email, 'email');
        emptyCheck($pass, 'pass');
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
                    $sql = 'SELECT pass FROM users WHERE email = :email AND delete_flg = 0';
                    $data = [':email' => $email];
                    $item = queryPost($sql, $data, $dbh);
                    $result = $item->fetch(PDO::FETCH_ASSOC);
                    //パスワードが一致するか確認
                    if($result && password_verify($pass, array_shift($result))){
                        error_log('パスワードが一致しました');
                        //セッションにidとlogin_timeとlogin_limitを入れる
                        header('Location:myPage-view.php');
                    }else{
                        debug('パスワードが合いません');
                        $err_msg['error'] = 'EmailもしくはPasswordが合いません';                        
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
    <title>Match-Code</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
</head>
<body>
    <?php include('header.php'); ?>
    <main class="top-container">
        <section class="form-container">
            <div class="site-width">
                <h1>Login</h1>
                <form>
                    <label>Email<br/>
                        <input type="text" name="email">
                    </label><br>
                    <label>Password<br/>
                        <input type="password" name="pass">
                    </label><br>
                    <input type="checkbox" value="login">ログイン状態を保持する<br/>
                    <input type="submit" value="SEND">
                </form>
            </div>
        </section>
    </main>        
    <?php include('footer.php')?>
    <script src="../js/index.js"></script>
</body>
</html>