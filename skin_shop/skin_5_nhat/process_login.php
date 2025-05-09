<?php
include('./includes/config.php');
$email=addslashes(strip_tags($_REQUEST['email']));
$password=addslashes(strip_tags($_REQUEST['password']));
$thongtin_shop=mysqli_query($conn,"SELECT * FROM user_info WHERE domain='$web' ORDER BY user_id DESC LIMIT 1");
$r_shop=mysqli_fetch_assoc($thongtin_shop);
$shop=$r_shop['user_id'];
$thongtin=mysqli_query($conn,"SELECT *,count(*) AS total FROM user_info WHERE (email='$email' OR username='$email') AND shop='$shop'");
$r_tt=mysqli_fetch_assoc($thongtin);
if($r_tt['total']>0){
    $pass=md5($password);
    if($pass!=$r_tt['password']){
		$ok=0;
		$thongbao='Mật khẩu không đúng';
    }else if($r_tt['active']==0){
		$ok=0;
		$thongbao='Tài khoản của bạn chưa kích hoạt';
    }else if($r_tt['active']==2){
		$ok=0;
		$thongbao='Tài khoản của bạn đang tạm khóa';
    }else if($r_tt['active']==3){
		$ok=0;
		$thongbao='Tài khoản của bạn đã khóa vĩnh viễn';
    }else{
        $hientai=time();
        setcookie("user_id",token_login($r_tt['user_id'],$r_tt['password']),time() + 2593000,'/');
		$ok=1;
		$thongbao='Đang nhập thành công';
    }
}else{
	$ok=0;
	$thongbao='Tài khoản không tồn tại';
}
$info=array(
	'ok'=>$ok,
	'thongbao'=>$thongbao
);
echo json_encode($info);
?>