<?php
    require_once('function.php');

    //該当する記事のIDを所得
    $text_id=$_GET['id'];
    $id=$_SESSSION['user_id'];
    

    //該当するIDの記事もしくはチームのリーダーの情報を所得
    try{
        $db=getDb();
        $sql='SELECT U.id AS user_id FROM texts AS T JOIN users AS U ON T.user_id = U.id AND T.id = :id';
        $data=[':id'=>$text_id];
        $result=queryPost($sql,$data,$db);
        $items=$result->fetch(PDO::FETCH_ASSOC);
        $user_id=$items['user_id'];
        debug(print_r($user_id,true));
    }catch(Exception $e){
        debug('エラー:'.$e->getMessage());
    }