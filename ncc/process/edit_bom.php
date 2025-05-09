<?php
	$ho_ten = addslashes(strip_tags($_REQUEST['ho_ten']));
	$dien_thoai = addslashes(strip_tags($_REQUEST['dien_thoai']));
	$dia_chi = addslashes(strip_tags($_REQUEST['dia_chi']));
	$tinh_trang = addslashes(strip_tags($_REQUEST['tinh_trang']));
	$id = intval($_REQUEST['id']);
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
		$thongtin = mysqli_query($conn, "SELECT *,count(*) AS total FROM bom_hang WHERE id='$id' AND user_id='$user_id'");
		$r_tt = mysqli_fetch_assoc($thongtin);
		if ($r_tt['total'] == 0) {
			$ok = 0;
			$thongbao = 'Thất bại! Dữ liệu không tồn tại';

		} else {
			$thongbao = 'Sửa bom hàng thành công';
			$ok = 1;
			mysqli_query($conn, "UPDATE bom_hang SET ho_ten='$ho_ten',dien_thoai='$dien_thoai',dia_chi='$dia_chi',tinh_trang='$tinh_trang' WHERE id='$id' AND user_id='$user_id'");
		}
	}
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
	);
	echo json_encode($info);
?>