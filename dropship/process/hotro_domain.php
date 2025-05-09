<?php
	$price = 100000;
	if ($user_info['user_money'] < $price) {
		$ok = 0;
		$thongbao = 'Thất bại! Số dư của bạn không đủ';
	} else {
		$thongtin = mysqli_query($conn, "SELECT *,count(*) AS total FROM hotro_domain WHERE user_id='$user_id' AND status='0'");
		$r_tt = mysqli_fetch_assoc($thongtin);
		if ($r_tt['total'] > 0) {
			$ok = 0;
			$thongbao = 'Thất bại! Bạn đang có yêu cầu chờ xử lý';
		} else {
			$ok = 1;
			$thongbao = 'Thành công! Nhân viên hỗ trợ sẽ liên hệ lại bạn';
			$moi = $user_info['user_money'] - $price;
			$truoc = $user_info['user_money'] + $user_info['user_money2'];
			$sau = $truoc - $price;
			mysqli_query($conn, "UPDATE user_info SET user_money='$moi' WHERE user_id='$user_id'");
			mysqli_query($conn, "INSERT INTO hotro_domain(user_id,price,status,date_post)VALUES('$user_id','$price','0'," . time() . ")");
			mysqli_query($conn, "INSERT INTO lichsu_chitieu(user_id,sotien,truoc,sau,noidung,date_post)VALUES('$user_id','$price','$truoc','$sau','Yêu cầu hỗ trợ cài đặt tên miền'," . time() . ")");
		}
	}
	echo json_encode(array('ok' => 1, 'thongbao' => $thongbao));
?>