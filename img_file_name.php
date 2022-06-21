<?php
function img_file_name(){
  $f = 'uploadFile';
  $dir = 'upload/';
  $img = '';

  if($_FILES[$f]['name'] == '')
    return $img;
  // uploadされたfileの名前が空だったら
  // 詳しくは$_FILES['inputで指定したname']['name']で調べる

  $text = ''; 
  // fileの型を調べて、与えている
  if($_FILES[$f]['type']=='image/gif')
    $text = 'gif';
    elseif($_FILES[$f]['type']== 'image/pjpeg' || $_FILES[$f]['type']=='image/jpeg')
        $text='jpg';

  //fileの型が適しているかどうかの判断
  if($text == '')
  //uploadされた写真がgifでもjpegでもなかった
    exit('指定の形式で登録されていません');
  else{
    $imageName = date('Ymd-His').'-'.rand(1000,9999).'.'.$text;
    // ファイル名にあたるもの
        if( move_uploaded_file( $_FILES[$f]['tmp_name'], $dir.$imageName)){
            // dirはフォルダ、imageNameはファイル名としてuploadされたファイルを保存している
            // move_uploaded_file(string $from, string $to):左から右へ
            $img = $imageName;
        }else
            exit('画像ファイルのアップロードに失敗しました');
    };
 
    return $img;
}   
//imgには写真のファイル名が入っている == img_file_nameには写真のファイル名が入っている