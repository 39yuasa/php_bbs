<?php
session_start();
include('img_file_name.php');
include('connect.php');
// includeは外部ファイルをつなげる役割をしている
$m = '';

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
     $
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
    // 取ってきた情報をrowに配列として情報を返す
$m .= "<p>".$row["bba_id"]." ";
// . = >文字のつなぎ , .= => jsの+=と同じ意味
$m .= $row["use_name"]." ";
$m .= $row["date"]."</p>";
$m .= "<p>".nl2br( $row["msg"])."</p>";
// rowの中に入れてある情報を取りだしている
if( $row["img"] != NULL ){
    // 写真が投稿されているかの判断
    // !=でnullじゃない => 差y心が入っている
$m .= "<p><img src='upload/".$row['img']."' width='20%' height='20%'></p>";
}else{
    //写真が入っていないときに行われる処理
    echo 'ahh';
}
}
mysqli_free_result( $rst );
//使わないメモリの開放
mysqli_close( $com );
// データベース接続の切断


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