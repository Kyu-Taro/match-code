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
        $sql='SELECT * FROM teams WHERE id = :id';
        $data=[':id'=>$_SESSION['id']];
        $result=queryPost($sql,$data,$db);
        $teams=$result->fetch(PDO::FETCH_ASSOC);
    }catch(Exception $e){
        debug('エラー'.$e->getMessage());
    }

    //チームリーダー出なければ
    if($teams['user_id'] != $id){
        debug('true');
        debug(print_r($teams['user_id'],true));
        header('Location:'.$_SERVER['HTTP_REFERER']);
    }

    //POSTされていたら
    if(!empty($_POST)){
        $name=$_POST['name'];
        $text=$_POST['text'];

        //バリデーションチェック
        emptyCheck($name,'name');
        emptyCheck($text,'text');

        if(empty($err_msg)){
            try{
                $db=getDb();
                $sql='UPDATE teams SET name = :name,text = :text WHERE id = :team_id';
                $data=[':name'=>$name,':text'=>$text,':team_id'=>$_SESSION['id']];
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
    <title>Match-Code|チーム情報</title>
</head>
<body>
    <?php include('header.php')?>
    <section class="update-section">
        <div class="update-container">
            <div class="site-width">
                <h1 class="update-title">チーム内容編集</h1>
                <form action="update-team.php" method="POST">
                    チーム名<span class="error"><?php if(!empty($err_msg['name'])) echo sani($err_msg['name'])?></span><br/>
                    <input type="text" name="name" value="<?php echo $teams['name']?>"><br/>
                    活動内容<span class="error"><?php if(!empty($err_msg['text'])) echo sani($err_msg['text'])?></span><br/>
                    <textarea name="text" cols="50" rows="5"><?php echo $teams['text']?></textarea><br/>
                    <input type="submit" value="更新">
                </form>
            </div>
        </div>
    </section>
    <?php include('footer.php')?>
    <script src="../js/index.js"></script>
</body>
</html>