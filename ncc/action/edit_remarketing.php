<?php
	$thaythe['title'] = 'Sửa Remarketing';
	$thaythe['title_action'] = 'Sửa Remarketing';
	$id = preg_replace('/[^0-9a-zA-Z_-]/', '', $url_query['id']);
	$thongtin = mysqli_query($conn, "SELECT *, count(*) AS total FROM thongbao_shop WHERE id='$id' AND shop='$user_id'");
	$r_tt = mysqli_fetch_assoc($thongtin);
	if ($r_tt['total'] == 0) {
		$thongbao = "Dữ liệu không tồn tại...";
		$replace = array(
			'title' => 'Dữ liệu không tồn tại...',
			'description' => $index_setting['description'],
			'thongbao' => $thongbao,
			'link_chuyen' => '/ncc/list-remarketing',
		);
		echo $skin->skin_replace('skin_ncc/chuyenhuong', $replace);
		exit();
	}
	if ($r_tt['nhan'] != '') {
		$nhan = $r_tt['nhan'];
		$thongtin_member = mysqli_query($conn, "SELECT * FROM user_info WHERE user_id IN ($nhan) ORDER BY FIELD(user_id,$nhan) ASC");
		while ($r_m = mysqli_fetch_assoc($thongtin_member)) {
			$list_mem .= '<div class="li_member ' . $r_m['username'] . '" user="' . $r_m['user_id'] . '">' . $r_m['username'] . ' <i class="fa fa-close"></i></div>';
		}
	}
	$r_tt['list_nguoinhan'] = $list_mem;
	$r_tt['date_post'] = date('H:i:s d/m/Y', $r_tt['date_post']);
	$thaythe['box_right'] = $skin->skin_replace('skin_ncc/box_action/edit_remarketing', $r_tt);
?>