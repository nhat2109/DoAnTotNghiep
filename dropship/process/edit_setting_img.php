<?php
	$name = preg_replace('/[^0-9a-zA-Z_-]/', '', $_REQUEST['name']);
	$duoi = $check->duoi_file($_FILES['file']['name']);
	if (in_array($duoi, array('jpg', 'jpeg', 'png', 'gif', 'webp')) == true) {
		$minh_hoa = '/uploads/minh-hoa/' . $check->blank($name) . '-' . time() . '.' . $duoi;
		move_uploaded_file($_FILES['file']['tmp_name'], '..' . $minh_hoa);
		@unlink('..' . $index_setting[$name]);
		mysqli_query($conn, "UPDATE shop_setting SET value='$minh_hoa' WHERE name='$name' AND shop='$user_id'");
		$ok = 1;
		$thongbao = 'Sửa cài đặt thành công!';
	} else {
		$thongbao = 'Thất bại! Bạn chưa chọn ảnh mới';
		$ok = 0;
	}
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
	);
	echo json_encode($info);
?>