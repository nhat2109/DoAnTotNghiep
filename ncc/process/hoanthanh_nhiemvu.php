<?php
	$nhiemvu=intval($_REQUEST['nhiemvu']);
	$thongtin=mysqli_query($conn,"SELECT *,count(*) AS total FROM nhiem_vu WHERE id='$nhiemvu'");
	$r_tt=mysqli_fetch_assoc($thongtin);
	if($r_tt['total']==0){
		$ok=0;
		$thongbao='Thất bại! Nhiệm vụ không tồn tại';
	}else{
		$thongtin_lichsu=mysqli_query($conn,"SELECT *,count(*) AS total FROM lichsu_nhiemvu WHERE ngay='{$r_tt['ngay']}' AND user_id='$user_id' ORDER BY id DESC LIMIT 1");
		$r_ls=mysqli_fetch_assoc($thongtin_lichsu);
		if($r_ls['total']==0){
			$ok=0;
			$thongbao='Thất bại! Nhiệm vụ chưa được mở';
		}else{
			$ok=1;
			$thongbao='Thành công! Đã xác nhận hoàn thành nhiệm vụ';
			mysqli_query($conn,"UPDATE lichsu_nhiemvu SET hoan_thanh='1',update_post='$hientai' WHERE nhiem_vu='$nhiemvu' AND user_id='$user_id'");
		}
	}
	$info=array(
		'ok'=>$ok,
		'thongbao'=>$thongbao,
	);
	echo json_encode($info);
?>