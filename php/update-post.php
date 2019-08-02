<?php 
    require_once('function.php');
    auth();

    $id=$_SESSION['user_id'];
    if (!empty($_GET['id'])) {
        $_SESSION['id']=$_GET['id'];
        debug('IDを所得しました');
    }

    //ヘッダーとフッターのリンク
    $url1="myPage-view.php";
    $url2="create-view.php";
    $url3="post-view.php";
    $url4="team-view.php";
    $url5="../html/detail.html";
    $url6="setting.php";
    $link1="Mypage";
    $link2="Create";
    $link3="Post";
    $link4="Team";
    $link5="Detail";
    $link6="Setting";
    
    //ユーザー情報を所得してチームリーダーかどうかを判定する
    try{
        $db=getDb();
        $sql='SELECT * FROM texts WHERE id = :id';
        $data=[':id'=>$_SESSION['id']];
        $result=queryPost($sql,$data,$db);
        $texts=$result->fetch(PDO::FETCH_ASSOC);
    }catch(Exception $e){
        debug('エラー'.$e->getMessage());
    }

    //チームリーダー出なければ
    if($texts['user_id'] != $id){
        debug('true');
        debug(print_r($teams['user_id'],true));
        header('Location:'.$_SERVER['HTTP_REFERER']);
    }

    //POSTされていたら
    if(!empty($_POST)){
        $title=$_POST['title'];
        $text=$_POST['text'];
        $number=$_POST['number'];

        //バリデーションチェック
        emptyCheck($title,'title');
        emptyCheck($text,'text');
        emptyCheck($number,'number');

        if(empty($err_msg)){
            try{
                $db=getDb();
                $sql='UPDATE texts SET title = :title,text = :text,number = :number WHERE id = :text_id';
                $data=[':title'=>$title,':text'=>$text,':number'=>$number,':text_id'=>$_SESSION['id']];
                $result=queryPost($sql,$data,$db);
                if($result){
                    $_SESSION['msg-suc']='更新完了しました';
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
    <link rel="stylesheet" type="text/css" href="../css/update.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <title>Match-Code|投稿編集</title>
</head>
<body>
    <?php include('header.php')?>
    <section class="update-section">
        <div class="update-container">
            <div class="site-width">
                <h1 class="update-title">投稿編集</h1>
                <form action="update-post.php" method="POST">
                    タイトル<span class="error"><?php if(!empty($err_msg['title'])) echo sani($err_msg['title'])?></span><br/>
                    <input type="text" name="title" value="<?php echo $texts['title']?>"><br/>
                    募集人数<span class="error"><?php if(!empty($err_msg['number'])) echo $err_msg['number']?></span><br/>
                    <input type="tel" name="number" value="<?php echo $texts['number']?>"><br/>
                    募集内容<span class="error"><?php if(!empty($err_msg['text'])) echo sani($err_msg['text'])?></span><br/>
                    <textarea name="text" cols="50" rows="5"><?php echo $texts['text']?></textarea><br/>
                    <input type="submit" value="更新">
                </form>
            </div>
        </div>
    </section>
    <?php include('footer.php')?>
    <script src="../js/index.js"></script>
</body>
</html>