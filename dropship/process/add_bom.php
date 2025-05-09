<?php
	$ho_ten = addslashes(strip_tags($_REQUEST['ho_ten']));
	$dien_thoai = addslashes(strip_tags($_REQUEST['dien_thoai']));
	$dia_chi = addslashes(strip_tags($_REQUEST['dia_chi']));
	$tinh_trang = addslashes(strip_tags($_REQUEST['tinh_trang']));
	if (strlen($ho_ten) < 2) {
		$ok = 0;
		$thongbao = 'Thất bại! Bạn chưa nhập họ và tên';
	} else if (strlen($dien_thoai) < 8) {
		$ok = 0;
		$thongbao = 'Thất bại! Bạn chưa nhập số điện thoại';
	} else if ($dia_chi == '') {
		$ok = 0;
		$thongbao = 'Thất bại! Bạn chưa nhập địa chỉ';
	} else {
		$thongbao = 'Thêm bom hàng thành công';
		$ok = 1;
		mysqli_query($conn, "INSERT INTO bom_hang(user_id,ho_ten,dien_thoai,dia_chi,tinh_trang,date_post)VALUES('$user_id','$ho_ten','$dien_thoai','$dia_chi','$tinh_trang'," . time() . ")");
	}
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
	);
	echo json_encode($info);
?>