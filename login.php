<?php
session_start();
include('connect.php');
if(!empty($_POST)):
    if($_POST['name'] != '' && $_POST['pass'] != ''):
        $name = $_POST['name'];
        $pass = $_POST['pass'];
        $sql = "SELECT * FROM users WHERE (name = '$name' AND password = '$pass')";
        $rst =mysqli_query($com , $sql);
        if($row = mysqli_fetch_assoc($rst)):
            $_SESSION['userId'] = $row['id'];
            $_SESSION['username'] = $row['user'];
            header('Location:bbs.php');
            exit();
        else:
            echo '登録されていません';
        endif;
        mysqli_free_result($rst);
    endif;
    mySqli_close($com);
endif;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h2>ログイン画面</h2>
    <form action="" method = 'post'>
       <p>ユーザー名：<input type="text" name = 'name'></p> 
       <p>パスワード：<input type="password" name = 'pass'></p>
       <p><input type="submit" name ='sub' value ='ログイン'></p> 
    </form>
    <p>新規ユーザ登録の方はこちらからどうぞ</p>
    <p><a href="newuser.php">新規登録ページへ</a></p>
</body>
</html>