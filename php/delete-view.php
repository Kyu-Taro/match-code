<?php
    require_once('function.php');
    
    //ヘッダーとフッターに使うリンク
    $url1="index.php";
    $url2="register-view.php";
    $url3="post-view.php";
    $url4="team-view.php";
    $url5="../html/detail.html";
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
    <link rel="stylesheet" href="../css/delete.css" type="text/css">
    <title>Match-Code|退会</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
</head>
<body>
    <!--★コピーここから　位置はbodyの中です-->
<script type="text/javascript"><!--
(function (){  //即時関数で囲んでグローバル変数を消すため、この行はこのままで

//★星の色指定。増減可能。色名を順番に"●",と区切って、いくつでも並べる。最後の ] の前には ,(カンマ) 無し。１色指定も可
var colour=["#00fa9a","#ffff00","#f0f"];
var sparkles=50; //★原本50。キラキラ星の数

//指定ここまで-----------------★内容物が無くてもHTML5動作可能へ。複数色指定へ　2016/04/23-----------*/
/****************************
*  Tinkerbell Magic Sparkle *
*(c)2005-13 mf2fm web-design*
*  http://www.mf2fm.com/rv  *
* DON'T EDIT BELOW THIS BOX *
****************************/
var cNum=0;//■追加。色数のカウント
var x=ox=400;
var y=oy=300;
var swide=window.innerWidth, shigh=window.innerHeight;
var sleft=sdown=0;
var tiny=[], star=[], starv=[], starx=[], stary=[], tinyx=[], tinyy=[], tinyv=[];
window.onload=function() {
  var i, rats, rlef, rdow;
  for (var i=0; i<sparkles; i++) {
    var rats=createDiv(3, 3);
    rats.style.visibility="hidden";
    document.body.appendChild(tiny[i]=rats);
    starv[i]=0;
    tinyv[i]=0;
    var rats=createDiv(5, 5);
    rats.style.backgroundColor="transparent";
    rats.style.visibility="hidden";
    var rlef=createDiv(1, 5);
    var rdow=createDiv(5, 1);
    rats.appendChild(rlef);
    rats.appendChild(rdow);
    rlef.style.top="2px";
    rlef.style.left=0;
    rdow.style.top=0;
    rdow.style.left="2px";
    document.body.appendChild(star[i]=rats);
  }
  sparkle();
}
function sparkle() {
  var c;
  if (x!=ox || y!=oy) {
    ox=x;
    oy=y;
    for (c=0; c<sparkles; c++) if (!starv[c]) {
      star[c].style.left=(starx[c]=x)+"px";
      star[c].style.top=(stary[c]=y)+"px";
      star[c].style.clip="rect(0px, 5px, 5px, 0px)";
      star[c].childNodes[0].style.backgroundColor=star[c].childNodes[1].style.backgroundColor=colour[cNum%colour.length];cNum++;//■修正
      star[c].style.visibility="visible";
      starv[c]=50;
      break;
    }
  }
  for (c=0; c<sparkles; c++) {
    if (starv[c]) update_star(c);
    if (tinyv[c]) update_tiny(c);
  }
  setTimeout(sparkle, 40);
}
function update_star(i) {
  if (--starv[i]==25) star[i].style.clip="rect(1px, 4px, 4px, 1px)";
  if (starv[i]) {
    stary[i]+=1+Math.random()*3;
    if (stary[i]<shigh+sdown) {
      star[i].style.top=stary[i]+"px";
      starx[i]+=(i%5-2)/5;
      star[i].style.left=starx[i]+"px";
    }
    else { star[i].style.visibility="hidden"; starv[i]=0; return;}
  }
  else {
    tinyv[i]=50;
    tiny[i].style.top=(tinyy[i]=stary[i])+"px";
    tiny[i].style.left=(tinyx[i]=starx[i])+"px";
    tiny[i].style.width="2px";
    tiny[i].style.height="2px";
    tiny[i].style.backgroundColor=star[i].childNodes[0].style.backgroundColor;//■2013年版追加
    star[i].style.visibility="hidden";
    tiny[i].style.visibility="visible"
  }
}
function update_tiny(i) {
  if (--tinyv[i]==25) {
    tiny[i].style.width="1px";
    tiny[i].style.height="1px";
  }
  if (tinyv[i]) {
    tinyy[i]+=1+Math.random()*3;
    if (tinyy[i]<shigh+sdown) {
      tiny[i].style.top=tinyy[i]+"px";
      tinyx[i]+=(i%5-2)/5;
      tiny[i].style.left=tinyx[i]+"px";
    }
    else { tiny[i].style.visibility="hidden"; tinyv[i]=0; return;}
  }
  else tiny[i].style.visibility="hidden";
}
document.onmousemove=function (e){ y=e.pageY; x=e.pageX; sdown=window.pageYOffset; sleft=window.pageXOffset;}
function createDiv(height, width) {
  var div=document.createElement("div");
  div.style.position="absolute";
  div.style.height=height+"px";
  div.style.width=width+"px";
  div.style.overflow="hidden";
/*■2005年分削除  div.style.backgroundColor=color;*/
  return (div);
}
}());//即時関数終了
// --></script>
<!--★コピーここまで-->
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
    <script src="../js/index.js"></script>
</body>
</html>