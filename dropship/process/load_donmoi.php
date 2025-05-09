<?php
	$thongtin=mysqli_query($conn,"SELECT * FROM thongbao_don ORDER BY date_post DESC LIMIT 1");
	$r_tt=mysqli_fetch_assoc($thongtin);
	if($r_tt['id']==$_COOKIE['popup_don']){
		$show=0;
	}else{
		setcookie("popup_don",$r_tt['id'],time() + 3600,'/');
		$show=1;
		$noi_dung='Vừa có đơn hàng, trị giá <span>'.number_format($r_tt['tong_tien']) . 'đ</span>';
		$ho_ten=$r_tt['ho_ten'];
		$dien_thoai=substr($r_tt['dien_thoai'], 0,-3).'xxx';
	}
	$info = array(
		'show'=>$show,
		'noi_dung'=>$noi_dung,
		'ho_ten'=>$ho_ten,
		'dien_thoai'=>$dien_thoai,
	);
	echo json_encode($info);
?>