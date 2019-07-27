<?php
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
            <h1>Member registration</h1>
                <form>
                        <label>Name<br/>
                            <input type="text" name="name">
                        </label><br>
                        <label>Email<br/>
                            <input type="text" name="email">
                        </label><br>
                        <label>Password<br/>
                            <input type="password" name="pass">
                        </label><br>
                        <label>Retype password<br/>
                            <input type="password" name="repass">
                        </label><br>
                        <label>Age<br/>
                            <input type="number" name="age">
                        </label><br>
                        <label>Twitter<br/>
                            <input type="text" name="acount" value="@">
                        </label><br>
                        <label>Type<br/>
                            <input type="radio" name="type" value="engineer">エンジニア
                            <input type="radio" name="type" value="designer">デザイナー
                        </label><br>
                        <label>Skill<br/>
                            <textarea name="skill" cols=50 rows=5></textarea>
                        </label><br>
                        <label>Profile<br/>
                            <textarea name="profile" cols=50 rows=5></textarea>
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