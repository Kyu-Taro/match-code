<?php
    require('function.php');

    //ログインしてるかをチェック
    auth();

    //ヘッダーとフッターのリンク
    $url1="Logout.php";
    $url2="myPage-view.php";
    $url3="post-view.php";
    $url4="team-view.php";
    $url5="detail.php";
    $url6="setting.php";
    $link1="Logout";
    $link2="Mypage";
    $link3="Post";
    $link4="Team";
    $link5="Detail";
    $link6="Setting";

    //ユーザーIDの所得
    $id=$_SESSION['user_id'];

    if(!empty($_POST)){
        
        //POSTデーターを変数に格納
        $title=$_POST['title'];
        $name=$_POST['team_name'];
        $textContent=$_POST['text_content'];
        $teamContent=$_POST['team_content'];
        $number=$_POST['number'];

        //全て入力されているかのチェック
        emptyCheck($title,'title');
        emptyCheck($name,'team_name');
        emptyCheck($textContent,'text_content');
        emptyCheck($teamContent,'team_content');
        emptyCheck($number,'number');

        if(empty($err_msg)){
            ageCheck($number,'number');
        }

        if(empty($err_msg)){
            try{
                //投稿内容をtextsテーブルとteamsテーブルに登録
                $db=getDb();
                $sql='INSERT INTO texts(title,user_id,text,number) VALUES(:title,:user_id,:text,:number)';
                $data=[':title'=>$title,':user_id'=>$id,':text'=>$textContent,':number'=>$number];
                $result=queryPost($sql,$data,$db);
                if($result){
                    debug('textsテーブルに登録完了');
                }

                $sql='INSERT INTO teams(user_id,name,text) VALUES(:user_id,:name,:text)';
                $data=[':user_id'=>$id,':name'=>$name,':text'=>$teamContent];
                $result=queryPost($sql,$data,$db);
                $team_id=$db->lastInsertId();
                if($result){
                    debug('teamsテーブルに登録完了');
                }

                $sql='INSERT INTO affiliation(team_id,user_id) VALUES(:team_id,:user_id)';
                $data=[':team_id'=>$team_id,':user_id'=>$id];
                $result=queryPost($sql,$data,$db);
                debug('affliationテーブルに登録完了');

                header('Location:myPage-view.php');
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
    <link rel="stylesheet" type="text/css" href="../css/create.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <title>Match-Code|マイページ</title>
</head>
<body>
    <?php include('header.php')?>
    <section class="create-section">
        <div class="create-container">
            <div class="site-width">
                <h1 class="create-title">プロジェクト作成</h1>
                <form action="create-view.php" method="POST">
                    <input type="hidden" name="id" value="<?php echo $id?>">
                    
                    <label>タイトル<span class="error"><?php if(!empty($err_msg['title'])) echo $err_msg['title']?></span><br/>
                        <input type="text" name="title" value="<?php if(!empty($_POST['title'])) echo $_POST['title']?>"><br/>
                    </label>
                    <label>チーム名<span class="error"><?php if(!empty($err_msg['team_name'])) echo $err_msg['team_name']?></span><br/>
                        <input type="text" name="team_name" value="<?php if(!empty($_POST['team_name'])) echo $_POST['team_name']?>"><br/>
                    </label>
                    <label>募集内容<span class="error"><?php if(!empty($err_msg['text_content'])) echo $err_msg['text_content']?></span><br/>
                        <textarea name="text_content" cols="50" rows="5"><?php if(!empty($_POST['text_content'])) echo $_POST['text_content']?></textarea><br/>
                    </label>
                    <label>チーム説明<span class="error"><?php if(!empty($err_msg['team_content'])) echo $err_msg['team_content']?></span><br/>
                        <textarea name="team_content" cols="50" rows="5"><?php if(!empty($_POST['team_content'])) echo $_POST['team_content']?></textarea><br/>
                    </label>
                    <label>募集人数<span class="error"><?php if(!empty($err_msg['number'])) echo $err_msg['number']?></span><br/>
                        <input type="tel" name="number" value="<?php if(!empty($_POST['number'])) echo $_POST['number']?>"><br/>
                    </label>
                    <input type="submit" value="SEND">
                </form>
            </div>
        </div>
    </section>
    <?php include('footer.php')?>
    <script src="../js/index.js"></script>
</body>
</html>