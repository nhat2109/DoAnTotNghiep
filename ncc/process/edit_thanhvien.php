<?php
	$name = addslashes(strip_tags($_REQUEST['name']));
	$active = intval($_REQUEST['active']);
	$duoi = $check->duoi_file($_FILES['file']['name']);
	$id = intval($_REQUEST['id']);
	$thongtin = mysqli_query($conn, "SELECT *,count(*) AS total FROM user_info WHERE user_id='$id'");
	$r_tt = mysqli_fetch_assoc($thongtin);
	if ($r_tt['total'] == 0) {
		$ok = 0;
		$thongbao = 'Thành viên không tồn tại';
	} else {
		if (in_array($duoi, array('jpg', 'jpeg', 'png', 'gif', 'webp')) == true) {
			$minh_hoa = '/uploads/avatar/' . $check->blank($name) . '-' . time() . '.' . $duoi;
			move_uploaded_file($_FILES['file']['tmp_name'], '..' . $minh_hoa);
			$thongbao = 'Sửa thành viên thành công';
			$ok = 1;
			mysqli_query($conn, "UPDATE user_info SET name='$name',avatar='$minh_hoa',active='$active' WHERE user_id='$id'");
			@unlink('..' . $r_tt['avatar']);
		} else {
			mysqli_query($conn, "UPDATE user_info SET name='$name',active='$active' WHERE user_id='$id'");
			$thongbao = 'Sửa thành viên thành công';
			$ok = 1;
		}
	}
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
	);
	echo json_encode($info);
?>