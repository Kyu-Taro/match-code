<?php
//ヘッダーとフッターに使うリンク
    $url1="register-view.php";
    $url2="login-view.php";
    $url3="post-view.php";
    $url4="team-view.php";
    $url5="../html/detail.html";
    $link1="Regist";
    $link2="Login";
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
    <main id="register">
        <section class="top-container">
            <div class="form-container ">
                <form class="top-coment">
                    <h1>Regist</h1>
                    <label>Name
                        <input type="text" name="name">
                    </label><br>
                    <label>Email
                        <input type="text" name="mail">
                    </label><br>
                    <label>Password
                        <input type="password" name="pass">
                    </label><br>
                    <label>Retype password
                        <input type="password" name="repass">
                    </label><br>
                    <label>Age
                        <input type="bumber" name="age">
                    </label><br>
                    <label>Twitter
                        <input type="checkbox" name="twitter">
                    </label><br>
                    <label>
                        <input type="checkbox" name="type[]" value="engineer">エンジニア
                        <input type="checkbox" name="type[]" value="designer">デザイナー
                    </label><br>
                    <label>Skill
                        <textarea name="skill" cols=50 rows=5></textarea>
                    </label><br>
                    <label>Intoroduction
                        <textarea name="intoro" cols=50 rows=5></textarea>
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