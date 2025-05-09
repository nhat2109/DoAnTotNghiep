<?php
	$thoi_gian=addslashes(strip_tags($_REQUEST['thoi_gian']));
	if($thoi_gian!=''){
		$thongtin_hotro=mysqli_query($conn,"SELECT *,count(*) AS total FROM pop_hotro WHERE user_id='$user_id'");
		$r_ht=mysqli_fetch_assoc($thongtin_hotro);
		if($r_ht['total']==0){
			mysqli_query($conn,"INSERT INTO pop_hotro(user_id,thoi_gian,note,lan,date_post)VALUES('$user_id','$thoi_gian','','1','$hientai')");
		}else{
			mysqli_query($conn,"UPDATE pop_hotro SET thoi_gian='$thoi_gian' WHERE user_id='$user_id'");
		}
		$ok=1;
		$thongbao='Xác nhận thành công';
	}else{
		$ok=0;
		$thongbao='Vui lòng nhập thời gian nhận hõ trợ';
	}
	$info=array(
		'ok'=>$ok,
		'thongbao'=>$thongbao,
	);
	echo json_encode($info);
?>