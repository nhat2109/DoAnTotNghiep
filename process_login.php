<?php
$web=$_SERVER['HTTP_HOST'];
$web=str_replace('www.', '', $web);
$web_root=array('tongkho.vn','socdo.vn','socmoi.vn','soc.vn','beta.socdo.vn');
function token_login($user_id,$password){
    $pass_1=substr($password, 0,8);
    $pass_2=substr($password, 8,8);
    $pass_3=substr($password, 16,8);
    $pass_4=substr($password, 24,8);
    $string=$pass_1.'-'.$pass_3.'-'.$pass_2.''.$user_id.'-'.$pass_2.'-'.$pass_4;
    $token_login=base64_encode($string);
    return $token_login;
}
if(in_array($web, $web_root)==false){
    include('./shop/process_login.php');
    exit();
}
?>