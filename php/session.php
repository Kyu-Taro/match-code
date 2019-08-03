<?php
    require_once('function.php');
    $_SESSION['msg-suc'] = 'ログアウトしました';
    header('Location:index.php');
