<?php
//sessionの開始と有効期限の変更
// session_save_path("c:/xampp/php/tmp");
session_save_path("/var/tmp");
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
const ERROR7="※半角英数字で入力してください";

//エラーメッセージの配列
$err_msg=[];

//デバッグの設定
$debug_flg=true;
function debug($str){
    global $debug_flg;
    if ($debug_flg) {
        error_log('デバッグ:'.$str);
    }
}

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

// 半角英数字チェック
function harfCheck($str, $key){
    if(!preg_match("/^[a-zA-Z0-9]+$/", $str)){
    global $err_msg;
    $err_msg[$key] = ERROR7;
    }
}

//セッションを１回だけ取り削除
function getSession($key){
    if(!empty($_SESSION[$key])){
        $data = $_SESSION[$key];
        $_SESSION[$key] = "";
        return $data;
    }
}

function auth(){
    //ログイン判定
    if (!empty($_SESSION['login_time'])) {
        if (time() > $_SESSION['login_time'] + $_SESSION['login_limit']) {
            debug('ログイン有効機嫌が過ぎています');
            header('Location:login-view.php');
        } else {
            $_SESSION['login_time']=time();
            debug('ログイン有効期限内です');
        }
    } else {
        debug('ログインしていません');
        header('Location:login-view.php');
    }
}

//サニタイズ
function sani($str){
    return htmlspecialchars($str);
}

//画像のアップロード処理とバリデーション
function uploadImg($file,$key){
    if (isset($file['error']) && is_int($file['error'])) {
        try {
            switch ($file['error']) {
                case UPLOAD_ERR_OK:
                    break;
                case UPLOAD_ERR_NO_FILE:
                    return 'no-file';
                case UPLOAD_ERR_INI_SIZE:
                case UPLOAD_ERR_FORM_SIZE:
                    throw new RuntimeException('ファイルサイズが大き過ぎます');
                default:
                    throw new RuntimeException('その他のエラーが発生しました');
            }
            $type=@exif_imagetype($file['tmp_name']);
            if (!in_array($type, [IMAGETYPE_GIF,IMAGETYPE_JPEG,IMAGETYPE_PNG], true)) {
                throw new RuntimeException('画像形式が違います');
            }
            $path='../img/uploads/'.sha1_file($file['tmp_name']).image_type_to_extension($type);
            if (!move_uploaded_file($file['tmp_name'], $path)) {
                throw new EuntimeException('ファイル保存時にエラーが出ました');
            }
            chmod($path, 0644);
            return $path;
        } catch (RuntimeException $e) {
            global $err_msg;
            $err_msg[$key]=$e->getMessage();
            debug('エラー:'.$e->getMessage());
        } catch (EuntimeException $e) {
            debug('エラー:'.$e->getMessage());
        }
    }else{
        debug('エラーです');
    }
}
