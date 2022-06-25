
<?php
session_start();
    include("connect.php");
    include("img_file_name.php");
    $m = "";
    
// データベースに保存する処理
if(isset($_POST['sub'])):
    $u_id = $_SESSION['userId'];
    $msg = $_POST['msg'];
    $img = img_file_name();
    // include('img_file_name.php')の中にある img_file_name()を働かせて値を取得している
    // 写真を処理してくれるもの
    $sql = "INSERT INTO bbs (u_id , msg , date , img)
            VALUES ('{$u_id}' , '{$msg}' , now() , '{$img}')";
    //持ってきたデータベースの箱に対して順番に入れる
    $rst = mysqli_query($com , $sql);    
endif; 

    //ユーザ名の変更
    if( isset( $_POST["movesub"])){
        $old = $_POST["oldname"];
        // 以前の名前
        $new = $_POST["newname"];
        //変更後の名前
    
        //旧ユーザ名がusersテーブルにあるかの？2行くらい
        $sql = "SELECT * FROM users WHERE user='{$old}'";
        //以前使っていた名前と同じものをデータベースから取ってくる
        $rst = mysqli_query( $com, $sql );

        //旧ユーザ名があったらusersテーブル内の指定されたユーザの名前を変更する
        //if内の{}を含めて5行くらい、UPDATE文を使用する
        if( $row = mysqli_fetch_assoc( $rst ) ){
            // そのユーザーのid番号の取得
            $id = $row["id"];
            // updateをかける、指定しているid番号のnameを変えるよという処理
            $sql = "UPDATE users SET name='{$new}' WHERE id='{$id}'";
            $rst = mysqli_query( $com, $sql );
        }
    }
    // ゆーざー情報の削除
    if( isset( $_POST["delsub"]) ){
        $name = $_POST["delname"];

        $sql = "SELECT * FROM users WHERE name='{$name}'";
        $rst = mysqli_query( $con, $sql );
    // 上と一緒
        if( $row = mysqli_fetch_assoc( $rst ) ){
             // そのユーザーのid番号の取得
            $id = $row["id"];
            // usersテーブルから指定のidのユーザを削除する
            $sql = "DELETE FROM users WHERE id='{$id}'";
            $rst = mysqli_query( $con, $sql );
            // bbsテーブルから指定のユーザが投稿した記事を削除する
            $sql = "DELETE FROM bbs WHERE u_id='{$id}'";
            $rst = mysqli_query( $con, $sql );
            // ここ大事
            // 片方に情報が残っているとそのあと追加される情報がずれてしまうため、両方消す
        }
    }
    if( isset( $_POST["imgsub"] ) ){
        $cid = $_POST["imgid"];
        $img = img_file_name();
        // 写真を勝手に処理してくれる関数発動
        //アップデートの処理はやっていること一緒
        $sql = "UPDATE bbs SET img='{$img}' WHERE id='{$cid}'";
        $rst = mysqli_query($com, $sql);
    }

    $sql = "SELECT *,bbs.id as b_id, users.name as u_name
    FROM bbs LEFT JOIN users 
    ON bbs.u_id = users.id ORDER BY bbs.id DESC";
    $rst = mysqli_query( $com, $sql );

    while( $row = mysqli_fetch_array( $rst )){
        $m .= "<p>".$row["b_id"]." ";
        $m .= $row["u_name"]." ";
        $m .= $row["date"]."</p>";
        $m .= "<p>".nl2br( $row["msg"])."</p>";
        if( $row["img"] != NULL ){
            $m .= "<p><img src='upload/".$row['img']."' width='20%' height='20%'></p>";
        }
    }
    mysqli_free_result( $rst );
    mysqli_close( $com );

    //48から63行目、bbsのページに書いてある

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
  
    <h2>投稿画面</h2>
    <p>投稿者：<?php echo $_SESSION['username'] ;?></p>
    <form action="" method = "post"  accept-charset="UTF-8" enctype="multipart/form-data">
        <p><textarea name="msg" cols="70" rows="10"></textarea></p>
        画像(GIF/JPEG形式、100KB以下):<input type="file" name="uploadFile" size="40">
        <input type="submit" name="sub" value="投稿">
    </form>
    <h1>管理画面</h1>
    <form method="post" action="" accept-charset="UTF-8" enctype="multipart/form-data">
        <!-- ユーザ名の変更 -->
        <p>ユーザ名の変更</p>
        <p>旧ユーザ名：<input type="text" name="oldname"></p>
        <p>新ユーザ名：<input type="text" name="newname"></p>
        <p><input type="submit" name="movesub" value="変更"></p>

        <!-- ユーザ名の削除 -->
        <p>ユーザ名の削除</p>
        <p>削除するユーザ名：<input type="text" name="delname"></p>
        <p><input type="submit" name="delsub" value="削除"></p>

        <!-- 画像変更 -->
        <p>画像の変更</p>
        <p>画像変更するコメントID：<input type="text" name="imgid"></p>
        <p>画像(GIF/JPEG形式、100KB以下):<input type="file" name="uploadFile" size="40"></p>
        <p><input type="submit" name="imgsub" value="変更"></p>
    </form>
    <?php
        print $m;
    ?>
    
</body>
</html>