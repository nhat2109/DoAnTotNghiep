<?php
	$thaythe['title'] = 'Link tuyển dụng thành viên';
	$thaythe['title_action'] = 'Link tuyển dụng thành viên';
	$limit = 100;
	$id = preg_replace('/[^0-9a-zA-Z_-]/', '', $url_query['id']);
	if ($user_info['leader'] == 0) {
		$thongbao = "Bạn không có quyền truy cập...";
		$replace = array(
			'title' => 'Bạn không có quyền truy cập...',
			'description' => $index_setting['description'],
			'thongbao' => $thongbao,
			'link_chuyen' => '/dropship/dangky-leader',
		);
		echo $skin->skin_replace('skin_dropship/chuyenhuong', $replace);
		exit();
	} else {

	}
	$bien = array(
		'user_id' => $user_id,
		'link_tuyendung' => 'https://socdo.vn/dangky-banhang.html?affgroup=' . $user_id,
	);
	$thaythe['box_right'] = $skin->skin_replace('skin_dropship/box_action/list_tuyendung_nhom', $bien);
?>