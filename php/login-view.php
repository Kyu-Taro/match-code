<?php
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