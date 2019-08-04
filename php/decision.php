<?php
    require_once('function.php');
    auth();

    $id=$_POST['hidden'];
    $ans=$_POST['submit'];

    //参加可否を判定する
    if($ans == '承諾'){
        $ans=1;
    }else{
        $ans=2;
    }
    

    //DBに登録する
    try{
        $db=getDb();
        $sql='UPDATE entory SET decision = :ans WHERE id = :id';
        $data=[':ans'=>$ans,':id'=>$id];
        $result=queryPost($sql,$data,$db);
        if($result && $ans == 1){
            debug('承諾しました');
            header('Location:news.php');
        }else{
            debug('拒否しました');
            header('Location:myPage-view.php');
        }
    }catch(Exception $e){
        debug('エラー:'.$e->getMessage());
    }