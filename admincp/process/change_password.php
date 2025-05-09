<?php 

$old_pass = addslashes($_REQUEST['old_pass']);
	$pass = md5($old_pass);
	$new_pass = addslashes($_REQUEST['new_pass']);
	$confirm = addslashes($_REQUEST['confirm']);
	if (!isset($_COOKIE['emin_id'])) {
		$ok = 0;
		$thongbao = 'Bạn chưa đăng nhập';
	} else {
		if (strlen($new_pass) < 6) {
			$thongbao = "Mật khẩu mới phải dài từ 6 ký tự";
			$ok = 0;
		} else if ($new_pass != $confirm) {
			$thongbao = "Nhập lại mật khẩu mới không khớp";
			$ok = 0;
		} else {
			$user_id = $user_info['id'];
			$thongtin = mysqli_query($conn, "SELECT * FROM emin_info WHERE id='$user_id'");
			$r_tt = mysqli_fetch_assoc($thongtin);
			if ($r_tt['password'] != $pass) {
				$ok = 0;
				$thongbao = "Mật khẩu hiện tại không đúng";
			} else {
				$password = md5($new_pass);
				mysqli_query($conn, "UPDATE emin_info SET password='$password' WHERE id='$user_id'");
				$ok = 1;
				$thongbao = 'Đổi mật khẩu thành công';

			}
		}
	}
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
	);
	echo json_encode($info);?>