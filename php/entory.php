<?php
    require_once('function.php');

    //該当する記事のIDを所得
    $text_id=$_GET['id'];
    $id=$_SESSION['user_id'];
    

    //該当するIDの記事もしくはチームのリーダーの情報を所得
    try{
        $db=getDb();
        $sql='SELECT U.id AS user_id FROM texts AS T JOIN users AS U ON T.user_id = U.id AND T.id = :id';
        $data=[':id'=>$text_id];
        $result=queryPost($sql,$data,$db);
        $items=$result->fetch(PDO::FETCH_ASSOC);
        $user_id=$items['user_id'];
        
        $sql='INSERT INTO entory(eh_id,rd_id,decision,created_at,pj_id) VALUES(:id,:user_id,:decision,:created_at,:pj_id)';
        $data=[':id'=>$id,':user_id'=>$user_id,'decision'=>0,':created_at'=>date("Y/m/d H:i:s"),':pj_id'=>$text_id];
        $result=queryPost($sql,$data,$db);

        header('Location:myPage-view.php');
    }catch(Exception $e){
        debug('エラー:'.$e->getMessage());
    }