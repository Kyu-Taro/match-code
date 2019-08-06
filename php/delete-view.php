  <?php
    require_once('function.php');
    
    //ヘッダーとフッターに使うリンク
    $url1="index.php";
    $url2="register-view.php";
    $url3="post-view.php";
    $url4="team-view.php";
    $url5="detail.php";
    $url6="myPage-view.php";
    $link1="Top";
    $link2="Regist";
    $link3="Post";
    $link4="Team";
    $link5="Detail";
    $link6="Mypage";

    if(!empty($_POST)){
        debug('POST送信があります');
        error_log('POSTの中身'.print_r($_POST,true));
        $withdraw = ($_POST["delete"] == "Yes") ? true : false;
        if($withdraw){
            debug('退会します');
                try{
                    $dbh = getDb();
                    $sql = 'UPDATE users SET delete_flg = 1 WHERE id = :id';
                    $data = [':id' => $_SESSION['user_id']];
                    $item = queryPost($sql, $data, $dbh);
                    if($item){
                        error_log('退会処理完了です');
                        //セッション中身を削除
                        $_SESSION = [];
                        //セッションクッキー破壊
                        if(isset($_COOKIE[session_name()])){
                        $params = session_get_cookie_params();
                        setcookie(session_name(), '', time()-3600, $params['path']);
                        }
                        //セッション破壊
                        session_destroy();
                        header('Location:index.php');
                        exit();
                    }else{
                        debug('退会処理に失敗しました');
                        $err_msg['error'] = 'エラーが発生しました。しばらく経ってからもい一度やり直してください';                        
                    }
                }catch (Exception $e){
                    debug($e->getMessage());
                    $err_msg['error'] = 'エラーが発生しました';
                }

            }else{
                debug('退会しません');
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
    <link rel="stylesheet" href="../css/withdraw.css" type="text/css">
    <title>Match-Code|退会</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
</head>
<body>
    <?php include('header.php'); ?>
    <main class="top-container">
    <div class="js-delete">
        <section class="form-container">            
            <div class="site-width">
                <h1 class="del-title">本当に退会しますか？</h1>
                <p class="error"><?php if(!empty($err_msg['error'])) echo $err_msg['error'] ?></p>
                <p>退会すると、すべてのアカウント情報が削除されます。</p>
                <p>本当に退会してもよろしいでしょうか。</p>
                <form action="" method="POST">
                    
                   <input type="submit" name="delete" value="Yes">
                   <input type="submit" name="delete" value="No">
                </form>
            </div>
        </section>
        </div>
    </main>        
    <?php include('footer.php')?>
    <script src="../js/withdraw.js"></script>
    <script src="../js/index.js"></script>
</body>
</html>