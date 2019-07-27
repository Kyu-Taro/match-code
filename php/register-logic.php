<?php
require('function.php');

//POSTデータを変数に格納
    $name=$_POST['name'];
    $email=$_POST['email'];
    $pass=$_POST['pass'];
    $repass=$_POST['repass'];
    $age=$_POST['age'];
    $type=$_POST['type'];
    $skill=$_POST['skill'];
    $profile=$_POST['profile'];

    //POSTデーターが空ではないかのチェック
    emptyCheck($name,'name');
    emptyCheck($email,'email');
    emptyCheck($pass,'pass');
    emptyCheck($age,'age');
    emptyCheck($type,'type');
    emptyCheck($skill,'skill');
    emptyCheck($profile,'profile');

    //Emailの形式チェック
    if(empty($err_msg)){
        emailCheck($email,'email');
    }

    //年齢のが数字かどうかのチェック
    if(empty($err_msg)){
        ageCheck($age,'age');
    }

    //パスワードのバリデーションチェック
    if(empty($err_msg)){
        passCheck($pass,$repass,'repass');
        // passCheckNumber($repass,'repass');
        // passCheckNumber($pass,'pass');
    }

    //メールアドレスがすでに登録されているものがないか
    if(empty($err_msg)){
        try{
            $db=getDb();
            $sql='SELECT * FROM users WHERE email = :email';
            $data=[':email'=>$email];
            $item=queryPost($sql,$data,$db);
            if($item){
                $err_msg['email']=ERROR6;
            }
        }catch(Exception $e){
            
        }
    }

    //全てのバリデーションが終わり画面遷移の操作
    if(empty($err_msg)){
        header('Location:myPage-view.php');
    }else{
        $_SESSION['name']=$name;
        $_SESSION['email']=$email;
        $_SESSION['pass']=$pass;
        $_SESSION['age']=$age;
        $_SESSION['type']=$type;
        $_SESSION['skill']=$skill;
        $_SESSION['profile']=$profile;
        $_SESSION['error']=$err_msg;
        header('Location:register-view.php');
    }
?>