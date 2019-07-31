<?php
    require_once('function.php');
    auth();

    //ヘッダーとフッターに使うリンク
    $url1="create-view.php";
    $url2="setting.php";
    $url3="post-view.php";
    $url4="team-view.php";
    $url5="../html/detail.html";
    $url6="myPage-view.php";
    $link1="Create";
    $link2="Setting";
    $link3="Post";
    $link4="Team";
    $link5="Detail";
    $link6="Mypage";

    $text_id=$_GET['id'];

    try{
        $db=getDb();
        $sql='SELECT T.title,T.text,T.number,U.name FROM texts AS T JOIN users AS U ON T.user_id = U.id AND T.id = :id';
        $data=[':id'=>$text_id];
        $result=queryPost($sql,$data,$db);
        $items=$result->fetch(PDO::FETCH_ASSOC);

        $sql='SELECT * FROM teams WHERE id = :id AND delete_flg = 0';
        $data=[':id'=>$text_id];
        $result=queryPost($sql,$data,$db);
        $teams=$result->fetch(PDO::FETCH_ASSOC);

        $sql='SELECT count(*) AS number FROM affiliation WHERE team_id = :id';
        $data=['id'=>$text_id];
        $result=queryPost($sql,$data,$db);
        $aff=$result->fetch(PDO::FETCH_ASSOC);

    }catch(Exception $e){
        debug('テキスト情報所得エラー');
    }
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="../css/postDetail.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <title>Match-Code|募集詳細</title>
</head>
<body>
    <?php require_once('header.php')?>
    <section class="detail-section">
        <div class="detail-container">
            <div class="site-width">
                <div class="detail">
                    <h1><?php echo sani($items['title'])?></h1>
                        投稿者:<?php echo sani($items['name'])?><br/>
                        募集人数:<?php echo sani($items['number'])?><br/>
                        現在の人数:<?php echo sani($aff['number'])?>人<br/>
                        チーム名:<a href="teamDetail-view.php?id=<?php echo $text_id?>"><?php echo sani($teams['name'])?></a><br/>
                        内容:</td><td><?php echo sani($items['text'])?><br/>
                    <form action="entory.php">
                        <input type="submit" value="参加申請">
                    </form>
                </div>
            </div>
        </div>
    </section>
    <?php require_once('footer.php')?>
    <script src="../js/index.js"></script>
</body>
</html>