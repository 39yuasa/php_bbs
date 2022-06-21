<?php
function console_log($data){
    echo $data;
    echo '<script>';
    echo 'console.log('.json_encode($data).')';
    echo '</script>';
}
?>