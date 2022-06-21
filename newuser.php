<?php
session_start();
include('console/console.php');
// 最速コマンドsssts

$error['user'] = "";
$error['pass'] = "";
// formの値が空だったときに使う変数

if(!empty($_POST)):
    // 名前が空だったら
    if($_POST['user']==''):
        $error['user'] = 'blank';
    endif;
    // パスワードが空だったら
    if($_POST['pass']==''):
        $error['pass'] = 'blank';
    // パスワードの文字数が6文字より少なかったら
    elseif(strlen($_POST['pass'])<6):
        $error['pass'] ='length';
    endif;

    $judge = array_filter($error);// error配列の中身を確認
    // パスワードが空だった場合、{pass: 'blank'}こういう感じで打ち出される
    console_log($judge);
    if(empty($judge)):
        $_SESSION['join']=$_POST;
        // $_POSTの中には、usernameとpasswordが入っている
        // $_SESSION['join']['user'] 入力されたユーザ名を確認できる
        // $_SESSION['join']['pass'] 入力されたパスワードを確認できる
        header("Location: check.php");
        // checkへ移動
endif;
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
    <h2>ユーザー登録</h2>
    <form action="" method = 'post'>
    <p>ユーザ名：<input type="text" name="user"></p>
        <?php
            if( $error["user"] == "blank" ):
        ?>
            <p>ユーザ名を入力してください</p>
        <?php
            endif;
        ?>
        <p>パスワード：<input type="password" name="pass"></p>
        <?php
            if( $error["pass"] == "blank" ):
        ?>
            <p>パスワードを入力してください</p>
        <?php
            endif;
        ?>
        <?php
            if( $error["pass"] == "length" ):
        ?>
            <p>パスワードは6文字以上で入力してください</p>
        <?php
            endif;
        ?>
        <input type="submit" name="sub" value="登録">
    </form>
</body>
</html>