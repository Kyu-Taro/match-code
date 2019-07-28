<?php
require_once('function.php');
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