<?php
//sessionの開始と有効期限の変更
<<<<<<< HEAD
session_save_path("c:/xampp/php/tmp");
// session_save_path("/var/tmp");
=======
session_start();
session_save_path("c/:xampp/php/tmp");
session_save_path("/var/tmp");
>>>>>>> origin/master
ini_set('session.gc_maxlifetime',60*60*24*30);
ini_set('session.cookie_lifetime',60*60*24*30);
session_start();
//エラーログをとる設定
ini_set('log_errors','on');
ini_set('error_log','php.log');

//エラーメッセージ
const ERROR1="※入力必須です";
const ERROR2="※Emailの形式で入力してください";
const ERROR3="※パスワードは4文字以上で設定してください";
const ERROR4="※パスワードが一致しません";
const ERROR5="※数字のみで入力してください";
const ERROR6="※そのメールアドレスは既に登録されています";

//エラーメッセージの配列
$err_msg=[];

//DBの接続
function getDb(){
    $db="mysql:dbname=match_code; host=localhost; charset=utf8";
    $user="root";
    $pass="root";
    $option=[PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION];
    $dbh=new PDO($db,$user,$pass,$option);
    return $dbh;
}

//DBクエリー実行
function queryPost($sql,$data,$db){
    $stt=$db->prepare($sql);
    $stt->execute($data);
    return $stt;
}

//空じゃないかのエラーチェック
function emptyCheck($str,$key){
    if(empty($str)){
        global $err_msg;
        $err_msg[$key]=ERROR1;
    }
}

//Email形式かのバリデーションチェック
function emailCheck($str,$key){
    if(!preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\?\*\[|\]%'=~^\{\}\/\+!#&\$\._-])*@([a-zA-Z0-9_-])+\.([a-zA-Z0-9\._-]+)+$/", $str)){
        global $err_msg;
        $err_msg[$key]=ERROR2;
    }
}

//数字のみかどうかのバリデーションチェック
function ageCheck($str,$key){
    if(!preg_match("/^[0-9]+$/",$str)){
        global $err_msg;
        $err_msg[$key]=ERROR5;
    }
}

//パスワードが一致するかのチェック
function passCheck($str,$str2,$key){
    if($str !== $str2){
        global $err_msg;
        $err_msg[$key]=ERROR4;
    }
}

//パスワードの文字数をチェック
function passCheckNumber($str,$key){
    global $err_msg;
    if(mb_strlen($str) < 4){
        $err_msg[$key]=ERROR3;
    }
}