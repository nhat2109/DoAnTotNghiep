<?php
	$thaythe['title'] = 'Thông tin thành viên';
	$thaythe['title_action'] = 'Thông tin thành viên';
	$id = preg_replace('/[^0-9]/', '', $url_query['id']);
	$thongtin = mysqli_query($conn, "SELECT *, count(*) AS total FROM user_info WHERE user_id='$id' AND shop='$user_id'");
	$r_tt = mysqli_fetch_assoc($thongtin);
	if ($r_tt['total'] == 0) {
		$thongbao = "Thành viên này không tồn tại...";
		$replace = array(
			'title' => 'Thành viên không tồn tại...',
			'description' => $index_setting['description'],
			'thongbao' => $thongbao,
			'link_chuyen' => '/ncc/list-thanhvien',
		);
		echo $skin->skin_replace('skin_ncc/chuyenhuong', $replace);
		exit();
	}
	$thaythe['box_right'] = $skin->skin_replace('skin_ncc/box_action/edit_thanhvien', $r_tt);
?>