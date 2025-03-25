<?php
include('./includes/config.php');
$email=addslashes(strip_tags($_REQUEST['email']));
$password=addslashes(strip_tags($_REQUEST['password']));
$thongtin_shop=mysqli_query($conn,"SELECT * FROM user_info WHERE domain='$web' ORDER BY user_id DESC LIMIT 1");
$r_shop=mysqli_fetch_assoc($thongtin_shop);
$shop=$r_shop['user_id'];
$thongtin=mysqli_query($conn,"SELECT *,count(*) AS total FROM user_info WHERE (email='$email' OR username='$email') AND shop='$shop'");
$r_tt=mysqli_fetch_assoc($thongtin);
if($r_cat['cat_main']==0){
	$list_category_sub=$tach_category['list_main'];
}else{
	$thongtin_sub=mysqli_query($conn,"SELECT * FROM category_sanpham_shop WHERE cat_main='{$r_cat['cat_id']}' AND shop='{$r_shop['user_id']}'");
	$total_sub=mysqli_num_rows($thongtin_sub);
	if($total_sub>0){
		while($r_sub=mysqli_fetch_assoc($thongtin_sub)){
			$list_category_sub.='<li class=""><a href="/san-pham/'.$r_sub['cat_blank'].'.html" class="nav-link" title="'.$r_sub['cat_tieude'].'">'.$r_sub['cat_tieude'].'</a></li>';
		}
	}else{
		$thongtin_sub_main=mysqli_query($conn,"SELECT * FROM category_sanpham_shop WHERE cat_main='{$r_cat['cat_main']}' AND shop='{$r_shop['user_id']}'");
		while($r_sub_main=mysqli_fetch_assoc($thongtin_sub_main)){
			if($r_cat['cat_id']==$r_sub_main['cat_id']){
				$list_category_sub.='<li class="active"><a href="/san-pham/'.$r_sub_main['cat_blank'].'.html" class="nav-link" title="'.$r_sub_main['cat_tieude'].'">'.$r_sub_main['cat_tieude'].'</a></li>';
			}else{
				$list_category_sub.='<li class=""><a href="/san-pham/'.$r_sub_main['cat_blank'].'.html" class="nav-link" title="'.$r_sub_main['cat_tieude'].'">'.$r_sub_main['cat_tieude'].'</a></li>';
			}
		}
	}
}
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