<?php

//DBの接続
function etDb(){
    $db="mysql:dbname=match_code; host=localhost; charset=utf8";
    $user="root";
    $pass="root";
    $option=[PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,PDO::DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC];
    $dbh=new PDO($db,$user,$pass,$option);
    return $dbh;
}