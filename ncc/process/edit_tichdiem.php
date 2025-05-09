<?php
	$diem = intval($_REQUEST['diem']);
	$thongtin = mysqli_query($conn, "SELECT *,count(*) AS total FROM caidat_tichdiem WHERE shop='$user_id'");
	$r_tt = mysqli_fetch_assoc($thongtin);
	if ($r_tt['total'] > 0) {
		mysqli_query($conn, "UPDATE caidat_tichdiem SET diem='$diem' WHERE shop='$user_id'");
	} else {
		mysqli_query($conn, "INSERT INTO caidat_tichdiem(shop,diem)VALUES('$user_id','$diem')");
	}
	$info = array(
		'thongbao' => 'Lưu thay đổi thành công',
		'ok' => 1,
	);
	echo json_encode($info);
?>