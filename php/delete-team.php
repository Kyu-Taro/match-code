<?php 
    require_once('function.php');
    auth();

    $id=$_SESSION['user_id'];
    if (!empty($_GET['id'])) {
        $_SESSION['id']=$_GET['id'];
    }

    //ヘッダーとフッターのリンク
    $url1="myPage-view.php";
    $url2="create-view.php";
    $url3="post-view.php";
    $url4="team-view.php";
    $url5="detail.php";
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
        header('Location:'.$_SERVER['HTTP_REFERER']);
    }

    //POSTされていたら
    if(!empty($_POST)){
        $ans=$_POST['delete'];
        if ($ans == '削除') {
            try {
                $db=getDb();
                $sql='UPDATE teams SET delete_flg = 1 WHERE id = :team_id';
                $data=[':team_id'=>$_SESSION['id']];
                $result=queryPost($sql, $data, $db);

                $sql='UPDATE texts SET delete_flg = 1 WHERE id = :text_id';
                $data=[':text_id'=>$_SESSION['id']];
                $result=queryPost($sql,$data,$db);

                if ($result) {
                    $_SESSION['msg-suc']='更新完了しました';
                    header('Location:myPage-view.php');
                }
            } catch (Exception $e) {
                debug('エラー:'.$e->getMessage());
            }
        }else{
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
    <link rel="stylesheet" type="text/css" href="css/delete.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <title>Match-Code|チーム解散</title>
</head>
<body>
    <?php include('header.php')?>
    <section class="delete-section">
        <div class="delete-container">
            <div class="site-width">
                <h1 class="delete-title">チーム削除</h1>
                    <p>【チーム名】<?php echo sani($teams['name'])?></p>
                    <p>【活動内容】<?php echo sani($teams['text'])?></p>
                <form action="delete-team.php" method="POST">
                    <input type="submit" name="delete" value="削除">
                    <input type="submit" name="delete" value="戻る">
                </form>
            </div>
        </div>
    </section>
    <?php include('footer.php')?>
    <script src="js/index.js"></script>
</body>
</html>