<?php
session_start();
include('img_file_name.php');
include('connect.php');
$m = '';

// データベースに保存する処理
if(isset($_POST['sub'])):
    $u_id = $_SESSION['userId'];
    $msg = $_POST['msg'];
    $img = img_file_name();
    // 写真を処理してくれるもの
    $sql = "INSERT INTO bbs (u_id , msg , date , img)
            VALUES ('{$u_id}' , '{$msg}' , now() , '{$img}')";
            //持ってきたデータベースの箱に対して順番に入れる
    $rst = mysqli_query($com , $sql);     
endif; 

//2つのテーブルを結合させて必要なデータを抽出する
$sql = "SELECT *,bbs.id as bba_id, users.name as use_name
FROM bbs LEFT JOIN users 
ON bbs.u_id = users.id ORDER BY bbs.id DESC";
// b_id、u_nameは変数とか仮の値として新しく宣言されている
// leftは左のデータベースを軸にして右側とつなげるということ
// ONはsql文の書き方で条件式にするときに使う方法、今回はbbsのidとusersのidを比べている
// とってきたbbs.idを大きいの順に上から並べている

$rst = mysqli_query( $com, $sql );
while( $row = mysqli_fetch_array( $rst )){
$m .= "<p>".$row["bba_id"]." ";
$m .= $row["use_name"]." ";
$m .= $row["date"]."</p>";
$m .= "<p>".nl2br( $row["msg"])."</p>";
if( $row["img"] != NULL ){
$m .= "<p><img src='upload/".$row['img']."' width='20%' height='20%'></p>";
}else{
    echo 'ahh';
}
}
mysqli_free_result( $rst );
mysqli_close( $com );
// 28-41ずっと使っているので割愛


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
    <h2>投稿画面</h2>
    <p>投稿者：<?php echo $_SESSION['username'] ;?></p>
    <form action="" method = "post"  accept-charset="UTF-8" enctype="multipart/form-data">
        <p><textarea name="msg" cols="70" rows="10"></textarea></p>
        画像(GIF/JPEG形式、100KB以下):<input type="file" name="uploadFile" size="40">
        <input type="submit" name="sub" value="投稿">
    </form>
    <?php
        print $m;
    ?>
</body>
</html>