<?php
    session_start();
    include("connect.php");

    if( !isset( $_SESSION['join']) ){ // SESSION内にデータがない場合は再入力させる処理
        header( 'Location: newuser.php');
        exit();
    }
    if( isset( $_POST['sub']) ){
        //ユーザ登録処理を行う
        $sql = sprintf('INSERT INTO users SET user="%s", password="%s"',
                    mysqli_real_escape_string( $con, $_SESSION['join']['user']),
                    mysqli_real_escape_string( $con, $_SESSION['join']['pass']) ); //SQL文の作成
        mysqli_query( $con, $sql ); //SQL文の実行
        unset( $_SESSION['join'] ); //SESSIONを削除

        header('Location: thanks.html');
        exit();
    }
    mysqli_close( $con );
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
<h2>確認</h2>

<dl>
    <dt>ユーザ名</dt>
        <dd>
            <?php
                echo htmlspecialchars( $_SESSION['join']['user'], ENT_QUOTES, 'UTF-8');
            ?>
            <!-- ユーザー名の表示 -->
        </dd>
    <dt>パスワード</dt>
        <dd>
            [表示されません]
        </dd>
    
</dl>
<p><a href="newuser.php?action=rewrite">変更</a></p>
<form method="post" action="">
    <input type="submit" name="sub" value="登録">
</form>
</body>
</html>