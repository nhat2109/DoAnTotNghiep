<?php
	$domain = addslashes(strip_tags($_REQUEST['domain']));
	$domain = $domain . '.socdo.vn';
	$thongtin = mysqli_query($conn, "SELECT *,count(*) AS total FROM user_info WHERE domain='$domain'");
	$r_tt = mysqli_fetch_assoc($thongtin);
	if ($r_tt['total'] > 0) {
		$thongbao = '<i class="fa fa-warning"></i> Tên miền đã tồn tại';
	} else {
		$thongbao = '<i class="fa fa-check"></i> Đã áp dụng thành công';
		mysqli_query($conn, "UPDATE user_info SET domain='$domain' WHERE user_id='$user_id'");
	}
	echo json_encode(array('ok' => 1, 'thongbao' => $thongbao));
?>