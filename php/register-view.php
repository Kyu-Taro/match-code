<?php
require('function.php');
session_destroy();

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
                <form action="register-logic.php" method="POST">
                        <label>Name<span class="error"><?php if(!empty($_SESSION['error']['name'])) echo $_SESSION['error']['name']?> </span><br/>
                            <input type="text" name="name" value="<?php if(!empty($_SESSION['name'])) echo $_SESSION['name']?>">
                        </label><br>
                        <label>Email<br/>
                            <input type="text" name="email" value="<?php if(!empty($_SESSION['email'])) echo $_SESSION['email']?>">
                        </label><br>
                        <label>Password<?php if(!empty($_SESSION['error']['pass']))  echo "<br/>"?><span class="error"><?php if(!empty($_SESSION['error']['pass'])) echo $_SESSION['error']['pass']?></span><br/>
                            <input type="password" name="pass">
                        </label><br>
                        <label>Retype password<?php if(!empty($_SESSION['error']['repass']))  echo "<br/>"?><span class="error"><?php if(!empty($_SESSION['error']['repass'])) echo $_SESSION['error']['repass']?><br/>
                            <input type="password" name="repass">
                        </label><br>
                        <label>Age<span class="error"><?php if(!empty($_SESSION['error']['age'])) echo $_SESSION['error']['age']?></span><br/>
                            <input type="tel" name="age" value="<?php if(!empty($_SESSION['age'])) echo $_SESSION['age']?>">
                        </label><br>
                        <label>Type<span class="error"><?php if(!empty($_SESSION['error']['type'])) echo $_SESSION['error']['type']?></span><br/>
                            <input type="radio" name="type" value="engineer" <?php if(!empty($_SESSION['type']) && $_SESSION['type'] == 'engineer') echo 'checked'?>>エンジニア
                            <input type="radio" name="type" value="designer" <?php if(!empty($_SESSION['type']) && $_SESSION['type'] == 'designer') echo 'checked'?>>デザイナー
                        </label><br>
                        <label>Skill<span class="error"><?php if(!empty($_SESSION['error']['skill'])) echo $_SESSION['error']['skill']?></span><br/>
                        <textarea name="skill" cols=50 rows=5><?php if(!empty($_SESSION['skill'])) echo $_SESSION['skill']?></textarea>
                        </label><br>
                        <label>Profile<span class="error"><?php if(!empty($_SESSION['error']['profile'])) echo $_SESSION['error']['profile']?></span><br/>
                            <textarea name="profile" cols=50 rows=5><?php if(!empty($_SESSION['profile'])) echo $_SESSION['profile']?></textarea>
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